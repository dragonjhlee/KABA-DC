<?php

class SrizonFBUI {
	static function startPageWrap() {
		echo <<<END
		<div class="wrap">
END;
	}

	static function endPageWrap() {
		echo <<<END
		</div>
END;
	}

	static function startOptionWrapper() {
		global $wp_version;
		if (floatval($wp_version) >= 2.7):
			echo <<<END1
			<div id="poststuff" class="metabox-holder has-right-sidebar">
END1;
		else:
			echo <<<END2
			<div id="poststuff">
END2;
		endif;
	}

	static function endOptionWrapper() {
		echo <<<END
			</div>
END;
	}

	static function startRightColumn() {
		global $wp_version;
		if (floatval($wp_version) >= 2.7):
			echo <<<END1
				<div class="inner-sidebar">
					<div id="side-sortables" class="meta-box-sortabless ui-sortable" style="position:relative;">
END1;
		else:
			echo <<<END2
				<div id="moremeta">
					<div id="grabit" class="dbx-group">
END2;
		endif;
	}

	static function endRightColumn() {
		echo <<<END
					</div>
				</div>
END;
	}

	static function startLeftColumn() {
		global $wp_version;
		if (floatval($wp_version) >= 2.7):
			echo <<<END1
						<div class="has-sidebar sm-padded" >
							<div id="post-body-content" class="has-sidebar-content">
								<div class="meta-box-sortabless">
END1;
		else:
			echo <<<END2
						<div id="advancedstuff" class="dbx-group" >
END2;
		endif;
	}

	static function endLeftColumn() {
		global $wp_version;
		if (floatval($wp_version) >= 2.7):
			echo <<<END1
						</div>
							</div>
								</div>
END1;
		else:
			echo <<<END2
						</div>
END2;
		endif;
	}

	static function renderBoxHeader($id, $title, $right = false, $classes='') {
		global $wp_version;
		if (floatval($wp_version) >= 2.7) {
			?>
			<div id="<?php echo $id; ?>" class="postbox <?php echo $classes;?>">
			<div class="handlediv" title="Click to toggle"><br></div>
			<h3 class="hndle2"><span><?php echo $title ?></span></h3>
			<div class="inside">
		<?php
		} else {
			?>
			<fieldset id="<?php echo $id; ?>" class="dbx-box">
			<?php if (!$right): ?><div class="dbx-h-andle-wrapper"><?php endif; ?>
			<h3 class="dbx-handle"><?php echo $title ?></h3>
			<?php if (!$right): ?></div><?php endif; ?>

			<?php if (!$right): ?><div class="dbx-c-ontent-wrapper"><?php endif; ?>
			<div class="dbx-content">
		<?php
		}
	}

	static function renderBoxFooter($right = false) {
		global $wp_version;
		if (floatval($wp_version) >= 2.7) {
			?>
			</div>
			</div>
		<?php
		} else {
			?>
			<?php if (!$right): ?></div><?php endif; ?>
			</div>
			</fieldset>
		<?php
		}
	}
}