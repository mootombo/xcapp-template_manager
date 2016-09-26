<?php
	$searchdir = \OC::$SERVERROOT . '/themes/';
	$themename = '';
	$themeslogan = '';
	$found_return_name = false;
	$found_function_name = false;
	$found_return_slogan = false;
	$found_function_slogan = false;
?>

<div class="section" id="template_manager-admin">
	<h2><?php p($l->t('Template Manager')); ?></h2>
	<p class="descr">
		<em><?php p($l->t('Add templates to the following directory') . ': ' . $searchdir); ?>.</em>
	</p>
	<table style="width: 100%;">
		<tbody>
			<tr>
				<td><input type="radio" id="radio_none" name="themeswitcher" value="none" checked="true"/></td>
					<td>
					<p class="name"><?php p('(' . $l->t('none') . ')'); ?></p>
				</td>
				<td></td>
				<td><br><br><br></td>
			</tr>

			<?php foreach(glob($searchdir . '*', GLOB_ONLYDIR) as $themedir) {

				$themedir = str_replace($searchdir, '', $themedir); 

				$file = fopen($searchdir . $themedir . '/defaults.php', "r");
				if ($file) {
					while(!feof($file)) {
						$line = fgets($file);
						if ($found_function_name === false) { 
							$found_function_name = strrpos(strtolower($line), strtolower('public function getName'));
						} else {
							// function found, now for next lines
							$found_return_name = strrpos(strtolower($line), 'return');
							if ($found_return_name === false) {
								// not yet found
							} elseif ($themename == '') {
								// now theme name found
								$themename = trim(str_ireplace('return', '', $line));
								// strip last ';'
								$themename = substr($themename, 0, strlen($themename) - 1);
								
								// old themes =< OC 8.1: find $this->ThemeName and return value of it
								if (strtolower($themename) == strtolower('$this->ThemeName')) {
									$themename_real = '';
									$file2 = fopen($searchdir . $themedir . '/defaults.php', "r");
									if ($file2) {
										while(!feof($file2)) {
											$line = fgets($file2);
											$pos = strrpos(strtolower($line), strtolower('$this->ThemeName'));
											if ($pos === false) {
											} elseif ($themename_real == '') {
												$themename_real = trim(str_ireplace('$this->themename = ', '', $line));
												// strip last ';'
												$themename = substr($themename_real, 0, strlen($themename_real) - 1);
											}
										}
									}
									
									fclose($file2); 
								}
							}
						}

						if ($found_function_slogan === false) { 
							$found_function_slogan = strrpos(strtolower($line), strtolower('public function getSlogan'));
						} else {
							// function found, now for next lines
							$found_return_slogan = strrpos(strtolower($line), 'return');
							if ($found_return_slogan === false) {
								// not yet found
							} elseif ($themeslogan == '') {
								// now theme slogan found
								$themeslogan = trim(str_ireplace('return', '', $line));
								$themeslogan = substr($themeslogan, 0, strlen($themeslogan) - 1);
							}
						}

					}
				} 
				fclose($file);

				// strip quotation marks
				if ((substr($themeslogan, 0, 1) == '\'' && substr($themeslogan, strlen($themeslogan) - 1, 1) == '\'')
					|| (substr($themeslogan, 0, 1) == '"' && substr($themeslogan, strlen($themeslogan) - 1, 1) == '"')) {
					$themeslogan = substr($themeslogan, 1, strlen($themeslogan) - 2);
				}
				if ((substr($themename, 0, 1) == '\'' && substr($themename, strlen($themename) - 1, 1) == '\'')
					|| (substr($themename, 0, 1) == '"' && substr($themename, strlen($themename) - 1, 1) == '"')) {
					$themename = substr($themename, 1, strlen($themename) - 2);
				}


			?>
			<tr>
				<td><input type="radio" id="radio_<?php p($themedir); ?>" name="themeswitcher" value="themename_<?php p($themedir); ?>"/></td>
				
				<td>
					<p class="name"><?php p($themename); ?></p>
				</td>
				<td>
					<img class="logo_img" src="<?php p(\OC::$WEBROOT . '/themes/' . $themedir . '/core/img/logo.png'); ?>">
				</td>
				<td class="info_td">
					<br>
					<p class="slogan_title"><?php p($l->t('Slogan')); ?>:</p><p class="slogan"><?php p($themeslogan); ?></p>
					<p class="location_title"><?php p($l->t('Location')); ?>:</p><p class="location"><?php p(\OC::$SERVERROOT . '/themes/'); ?><strong><?php p($themedir); ?></strong></p>
					<br>
				</td>
			</tr>
			<?php 
				$themename = '';
				$themeslogan = '';
				$found_return_name = false;
				$found_function_name = false;
				$found_return_slogan = false;
				$found_function_slogan = false;
			} ?>
		</tbody>
	</table>

	<span class="msg-template_manager"></span>

</div>
