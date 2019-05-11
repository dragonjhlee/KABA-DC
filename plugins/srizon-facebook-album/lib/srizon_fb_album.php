<?php
define( 'JPATH_CACHE', dirname( __FILE__ ) . '/../cache' );

if ( ! class_exists( 'SrizonFbAlbum' ) ) {
	class SrizonFbAlbum {
		protected $sync_interval;
		protected $debug;
		protected $force_sync = false;
		protected $images = array(); // for albums
		protected $cover_ids = array();
		protected $images_merged = array();
		protected $access_token = '';
		protected $album_covers = array(); // for galleries
		protected $include_or_exclude;
		protected $list_for_inc_exc;

		/**
		 * @param int $sync_interval
		 *
		 * @throws Exception
		 */
		public function __construct( $sync_interval = 300, $a_token='' ) {
			$this->sync_interval = $sync_interval;
			if ( isset( $_REQUEST['debugjfb'] ) && $_REQUEST['debugjfb'] == 'yes' ) {
				$this->debug = true;
			}
			if ( isset( $_REQUEST['forcesync'] ) && $_REQUEST['forcesync'] == 'yes' ) {
				$this->force_sync = true;
			}
			$this->access_token = $a_token;
		}

		/**
		 * @param $album_ids
		 * @param $sorting
		 *
		 * @return array
		 */
		public function get_facebook_albums_images( $album_ids, $sorting = 'default' ) {
			$this->set_debug_message( 'Album IDs: ', $album_ids );
			$album_id_array = $this->parse_ids_to_array( $album_ids );
			$this->get_merged_image_array( $album_id_array );
			$this->sort_images( $sorting );

			return $this->images_merged;
		}

		/**
		 * @param $pageid
		 * @param $sorting
		 * @param $include_or_exclude
		 * @param $list_of_albums_for_include_or_exclude
		 *
		 * @return array
		 */
		public function get_facebook_gallery_covers( $pageid, $sorting, $include_or_exclude, $list_of_albums_for_include_or_exclude, $id ) {
			$this->include_or_exclude = $include_or_exclude;
			$this->list_for_inc_exc   = $this->parse_ids_to_array( $list_of_albums_for_include_or_exclude );
			$this->get_album_covers( $pageid, $id );
			$this->include_or_exclude_albums();
			$this->sort_images( $sorting );

			return $this->images_merged;
		}

		public function get_pagetitle( $pageid, $set, $id ) {
			$this->get_album_covers( $pageid, $id );
			foreach ( $this->images as $image ) {
				if ( $image['id'] == $set ) {
					return $image['txt'];
				}
			}

			return '';
		}

		protected function include_or_exclude_albums() {
			foreach ( $this->images as $image ) {
				if ( $this->include_or_exclude == 'exclude' ) {
					if ( in_array( $image['id'], $this->list_for_inc_exc ) ) {
						continue;
					}
				} else {
					if ( ! in_array( $image['id'], $this->list_for_inc_exc ) ) {
						continue;
					}
				}
				$this->images_merged[] = $image;
			}
		}

		protected function parse_ids_to_array( $lines ) {
			$lines     = str_replace( ' ', "\n", $lines );
			$lines_arr = explode( "\n", $lines );
			$id_arr    = array();
			foreach ( $lines_arr as $line ) {
				if ( strlen( trim( $line ) ) < 5 ) {
					continue;
				}
				if ( strpos( $line, 'set=a.' ) ) {
					$line = substr( $line, strpos( $line, 'set=a.' ) + 6 );
					$line = substr( $line, 0, strpos( $line, '.' ) );
				}
				$id_arr[] = trim( $line );
			}
			$this->set_debug_message( 'Dumping IDs', $id_arr );

			return $id_arr;
		}

		protected function set_debug_message( $title, $value = '' ) {
			if ( ! $this->debug ) {
				return;
			}
			echo '<h3>' . $title . '</h3>';
			echo '<pre>';
			print_r( $value );
			echo '</pre>';
		}

		protected function get_merged_image_array( $album_id_array ) {
			foreach ( $album_id_array as $album_id ) {
				$this->get_single_album_image_array( $album_id );
				$this->images_merged = array_merge( $this->images_merged, $this->images );
			}
		}

		protected function get_single_album_image_array( $album_id ) {
			$this->images = null;
			$this->images = array(); // clear it
			if ( $this->sync_required( $album_id ) ) {
				$this->get_remote_album( $album_id ); // try to sync
				if ( count( $this->images ) ) {
					$this->cache_it( $album_id ); // sync successful so cache it
				} else {
					$this->read_cache( $album_id ); // sync unsuccessful try to read from cache
					$this->cache_it( $album_id );
				}
			} else {
				$this->read_cache( $album_id );
			}
		}

		protected function get_album_covers( $pageid, $id ) {
			$this->images = null;
			$this->images = array(); // clear it
			if ( $this->sync_required( $id ) ) {
				$this->get_remote_gallery( $pageid ); // try to sync
				$this->set_cover_thumb();
				if ( count( $this->images ) ) {
					$this->cache_it( $id ); // sync successful so cache it
				} else {
					$this->read_cache( $id ); // sync unsuccessful try to read from cache
					$this->cache_it( $id );
				}
			} else {
				$this->read_cache( $id );
			}
		}

		protected function read_cache( $id ) {
			global $wpdb;
			$cachekey        = $wpdb->prefix . 'multi' . $id;
			$filename        = JPATH_CACHE . '/fbalbum/' . md5( $cachekey );
			$filename_backup = JPATH_CACHE . '/fbalbumbackup/' . md5( $cachekey );
			if ( is_file( $filename ) ) {
				$data         = file_get_contents( $filename );
				$this->images = json_decode( $data, true );
			} else if ( is_file( $filename_backup ) ) {
				$data         = file_get_contents( $filename_backup );
				$this->images = json_decode( $data, true );
			}
		}

		protected function cache_it( $id ) {
			global $wpdb;
			$cachekey = $wpdb->prefix . 'multi' . $id;
			if ( ! count( $this->images ) ) {
				return;
			}
			if ( ! is_dir( JPATH_CACHE . '/fbalbum' ) ) {
				if ( is_writable( JPATH_CACHE ) ) {
					mkdir( JPATH_CACHE . '/fbalbum', 0777, true );
				}
			}
			if ( ! is_dir( JPATH_CACHE . '/fbalbumbackup' ) ) {
				if ( is_writable( JPATH_CACHE ) ) {
					mkdir( JPATH_CACHE . '/fbalbumbackup', 0777, true );
				}
			}
			if ( ! is_writable( JPATH_CACHE . '/fbalbum' ) ) {
				$this->set_debug_message( 'Cache folder is not writable' );
			}
			$filename        = JPATH_CACHE . '/fbalbum/' . md5( $cachekey );
			$filename_backup = JPATH_CACHE . '/fbalbumbackup/' . md5( $cachekey );
			$data            = json_encode( $this->images );
			file_put_contents( $filename, $data );
			file_put_contents( $filename_backup, $data ); // keep a backup
		}

		protected function get_remote_album( $album_id ) {
			$url = 'https://graph.facebook.com/' . $album_id . '/photos?fields=images,created_time,updated_time';
			$url = $url . '&access_token=' . $this->access_token;
			$this->set_debug_message( 'Getting remote data from:', $url );

			$response = wp_remote_get( $url, array( 'timeout' => 30 ) );
			if ( is_wp_error( $response ) ) {
				$this->set_debug_message( 'Getting Data Failed', $response->get_error_message() );
			} else {
				$json = json_decode( $response['body'] );
				$this->extract_and_save_image_data( $json );
			}
		}


		protected function get_remote_gallery( $pageid ) {
			$url = "https://graph.facebook.com/" . $pageid . "/albums?fields=name,id,count,cover_photo,created_time,updated_time";
			$url = $url . '&access_token=' . $this->access_token;
			$this->set_debug_message( 'Getting remote data from:', $url );

			$response = wp_remote_get( $url, array( 'timeout' => 30 ) );
			if ( is_wp_error( $response ) ) {
				$this->set_debug_message( 'Getting Data Failed', $response->get_error_message() );
			} else {
				$json = json_decode( $response['body'] );

				$this->extract_and_save_image_data_gallery( $json );
			}
		}

		protected function extract_and_save_image_data( &$json ) {
			if ( is_array( $json->data ) ) {
				$i = count( $this->images );
				foreach ( $json->data as $obj ) {
					$this->images[ $i ]['src'] = $obj->images[0]->source;
					for ( $range = 0; $range < 12; $range ++ ) {
						if ( isset( $obj->images[ $range ]->source ) ) {
							$this->images[ $i ]['thumb']  = $obj->images[ $range ]->source;
							$this->images[ $i ]['height'] = $obj->images[ $range ]->height;
							$this->images[ $i ]['width']  = $obj->images[ $range ]->width;
						}
					}
					$tmp                                = isset( $obj->name ) ? $obj->name : '';
					$this->images[ $i ]['txt']          = htmlspecialchars( $tmp );
					$this->images[ $i ]['created_time'] = $obj->created_time;
					$this->images[ $i ]['updated_time'] = $obj->updated_time;
					$i ++;
				}
			} else {
				$this->set_debug_message( 'Not a valid json data for album', $json );
			}
		}

		protected function set_cover_thumb() {
			$i         = 0;
			$offset    = 0;
			$thisbatch = array_slice( $this->cover_ids, $offset, 50 );
			while ( count( $thisbatch ) ) {
				$ids = '?ids=' . implode( ',', $thisbatch );
				$url = "https://graph.facebook.com/" . $ids . "&fields=images";
				$url = $url . '&access_token=' . $this->access_token;
				$this->set_debug_message( 'Getting remote data from:', $url );
				$response = wp_remote_get( $url, array( 'timeout' => 30 ) );
				if ( is_wp_error( $response ) ) {
					$this->set_debug_message( 'Getting Data Failed', $response->get_error_message() );
					foreach ( $thisbatch as $id ) {
						$this->images[ $i ]['thumb']  = 'https://graph.facebook.com/' . $id . '/picture?type=normal';
						$this->images[ $i ]['height'] = '225';
						$this->images[ $i ]['width']  = '300';
						$i ++;
					}
				} else {
					$obj = json_decode( $response['body'] );
					foreach ( $thisbatch as $id ) {
						for ( $range = 0; $range < 12; $range ++ ) {
							if ( isset( $obj->$id->images[ $range ]->source ) ) {
								$this->images[ $i ]['thumb']  = $obj->$id->images[ $range ]->source;
								$this->images[ $i ]['height'] = $obj->$id->images[ $range ]->height;
								$this->images[ $i ]['width']  = $obj->$id->images[ $range ]->width;
							}
						}
						$i ++;
					}
				}
				$offset    += 50;
				$thisbatch = array_slice( $this->cover_ids, $offset, 50 );
			}
		}

		protected function extract_and_save_image_data_gallery( &$json ) {
			if ( is_array( $json->data ) ) {
				$i = count( $this->images );
				foreach ( $json->data as $obj ) {
					$count = isset( $obj->count ) ? $obj->count : '';
					if ( isset( $obj->cover_photo->id ) ) {
						$cover_photo = $obj->cover_photo->id;
					} else {
						$cover_photo = isset( $obj->cover_photo ) ? $obj->cover_photo : '';
					}
					if ( ! $count ) {
						continue;
					}
					if ( ! $cover_photo ) {
						continue;
					}
					$this->images[ $i ]['txt']          = isset( $obj->name ) ? $obj->name : 'Untitled Album';
					$this->images[ $i ]['txt']          = htmlspecialchars( $this->images[ $i ]['txt'] );
					$this->images[ $i ]['count']        = $count;
					$this->images[ $i ]['id']           = $obj->id;
					$this->cover_ids[ $i ]              = $cover_photo;
					$this->images[ $i ]['created_time'] = $obj->created_time;
					$this->images[ $i ]['updated_time'] = $obj->updated_time;
					$i ++;
				}
			} else {
				$this->set_debug_message( 'Not a valid json data for album', $json );
			}
		}

		protected function sync_required( $album_id ) {
			global $wpdb;
			$cachekey = $wpdb->prefix . 'multi' . $album_id;
			if ( $this->force_sync ) {
				return true;
			}
			$filename = JPATH_CACHE . '/fbalbum/' . md5( $cachekey );
			if ( is_file( $filename ) ) {
				$utime  = filemtime( $filename );
				$chtime = time() - $this->sync_interval;
				if ( $utime > $chtime ) {
					return false;
				}

				return true;
			}

			return true;
		}

		protected function sort_images( $sorting_photos ) {
			if ( $sorting_photos == 'default' ) {
				return;
			} // do not sort
			if ( $sorting_photos == 'modified' or $sorting_photos == 'modifiedr' ) {
				usort( $this->images_merged, 'sort_updated_time' );
			} else if ( $sorting_photos == 'created' or $sorting_photos == 'createdr' ) {
				usort( $this->images_merged, 'sort_created_time' );
			}
			if ( $sorting_photos == 'defaultr' or $sorting_photos == 'modifiedr' or $sorting_photos == 'createdr' ) {
				$this->images_merged = array_reverse( $this->images_merged );
			}
			if ( $sorting_photos == 'shuffle' ) {
				shuffle( $this->images_merged );
			}
		}
	}
}
