<?php

class SrizonFBTokenExtractor {
	static function getAllTokens() {
		$albumsAndGalleries = SrizonFBDB::getAllAlbumsAndGalleries();
		$albumsAndGalleries = self::extractTokens( $albumsAndGalleries );
		$tokens             = self::makeTokenArray( $albumsAndGalleries );

		return $tokens;
	}

	static function getAllAlbumsAndGalleries() {
		$albumsAndGalleries = SrizonFBDB::getAllAlbumsAndGalleries();
		$albumsAndGalleries = self::extractTokens( $albumsAndGalleries );

		return $albumsAndGalleries;
	}


	private static function extractTokens( $items ) {
		$items = stripslashes_deep( $items );
		foreach ( $items as $item ) {
			$item->options = maybe_unserialize( $item->options );
			$item->token   = $item->options['access_token'];
			$item->options = null;
		}

		return $items;
	}

	private static function makeTokenArray( $albumsAndGalleries ) {
		$tokens = array();
		foreach ( $albumsAndGalleries as $item ) {
			if ( $item->token ) {
				$index = $item->token;
			} else {
				$index = 'empty';
			}
			$tokens[ $index ]['val'] = $index;
			if ( $item->type == 'album' ) {
				$tokens[ $index ]['albums'][] = array( 'title' => $item->title, 'id' => $item->id );
			} else {
				$tokens[ $index ]['galleries'][] = array( 'title' => $item->title, 'id' => $item->id );
			}
		}

		return $tokens;
	}
}