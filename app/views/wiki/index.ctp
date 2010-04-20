<?php
App::import('Vendor', 'include_path');
App::import(
	'Vendor',
	'Text_Wiki_Mediawiki', 
	array('file' => 'Text' . DS . 'Wiki' . DS . 'Mediawiki.php')
);
$wiki=new Text_Wiki_Mediawiki();
$wiki->setFormatConf('Xhtml', 'translate', HTML_SPECIALCHARS);
?>

<?php if (!empty($canWrite)):?>
<div id="snavi">
<ul>
	<?php if (!$page['Wiki']['disabled']):?>
		<li><a href="#"><?php __('Active') ?></a></li>
	<?php else: ?>
		<li><?php __('Not Active') ?></li>
	<?php endif;?>

	<?php if ((empty($content['Wiki']['readonly']) || $CurrentUser->id == $page['Wiki']['last_modified_user_id'])):?>
		<li><?php echo $html->link(__('Edit',true), array('controller' => 'wiki', 'action' => 'edit', $path, $slug));?></li>
		<li><?php echo $html->link(__('New',true), array('controller' => 'wiki', 'action' => 'add', $path, 'new-page'));?></li>
	<?php endif;?>
</ul>
<?php endif;?>
</div>

<div class="breadcrumbs">
	<?php //echo $chaw->breadcrumbs($path, $slug);?>
</div>

<div class="clear"><!----></div>

<div class="wiki view">

<div class="wiki-navigation" style="width:200px; float:right;">

	<?php if (!empty($subNav)):?>
		<?php
			$nav = null;
			foreach ($subNav as $subpage):
					$title = ltrim($subpage['Wiki']['path'] . '/' . $subpage['Wiki']['slug'], '/');
					$nav .= $html->tag('li',
						$html->link($title, array($subpage['Wiki']['path'], $subpage['Wiki']['slug']))
					);
			endforeach;
			if (!empty($nav)) {
				echo $html->tag('div',
					'<h3>Sub Nav</h3>' .
					$html->tag('ul', $nav), array('class' => 'paths')
				);
			}
		?>
	<?php endif;?>

	<?php if (!empty($wikiNav)):?>
		<?php
			$nav = null;
			foreach ($wikiNav as $category):
				$nav .= $html->tag('li',
					$html->link(ltrim($category, '/'), array($category))
				);
			endforeach;
			if (!empty($nav)) {
				echo $html->tag('div',
					'<h3>'.__('Wiki Nav',true).'</h3>' .
					$html->tag('ul', $nav), array('class' => 'paths')
				);
			}
		?>
	<?php endif;?>

	<?php if (!empty($recentEntries)):?>
		<?php
			$nav = null;
			foreach ($recentEntries as $recent):
					$title = ltrim($recent['Wiki']['path'] . '/' . $recent['Wiki']['slug'], '/');
					$nav .= $html->tag('li',
						$html->link($title, array($recent['Wiki']['path'], $recent['Wiki']['slug']))
					);
			endforeach;
			if (!empty($nav)) {
				echo $html->tag('div',
					'<h2>'.__('Recent Entries',true).'</h2>' .
					$html->tag('ul', $nav), array('class' => 'paths')
				);
			}
		?>
	<?php endif;?>

</div>

<div style="float:left;">
<?php if (!empty($page)): ?>
	<div class="wiki-content">
		<div class="wiki-text">
			<?php echo $wiki->transform($page['Wiki']['body']);?>
		</div>
	</div>
<?php endif; ?>

<?php if (empty($page) && !empty($wiki)): ?>
	<div class="wiki-content">

		<?php foreach($wiki as $content):
			$data = h($text->truncate($content['Wiki']['body'], 420, '...', false, true));
		?>
			<?php if (strpos($data, '##') === false):?>
				<h3><?php
					echo $html->link(Inflector::humanize($content['Wiki']['slug']), array(
						'controller' => 'wiki', 'action' => 'index',
						$content['Wiki']['path'], $content['Wiki']['slug']
					));?>
				</h3>
			<?php endif; ?>

			<div class="wiki-text">
				<?php echo $data; ?>
			</div>

			<div class="actions">
				<?php echo $html->link(__('View',true), array(
						'controller' => 'wiki', 'action' => 'index',
						$content['Wiki']['path'], $content['Wiki']['slug']));
				?>
				<?php if (!empty($canWrite) && (empty($content['Wiki']['read_only']) || $CurrentUser->id == $content['Wiki']['last_modified_user_id'])):?>
					|
					<?php echo $html->link(__('Edit',true), array(
							'controller' => 'wiki', 'action' => 'edit',
							$content['Wiki']['path'], $content['Wiki']['slug']));
					?>
					|
					<?php echo $html->link(__('New',true), array(
							'controller' => 'wiki', 'action' => 'add',
							$content['Wiki']['path'], 'new-page'));
					?>
				<?php endif; ?>
			</div>

		<?php endforeach; ?>

	</div>
<?php endif; ?>

<?php if (empty($revisions) && !empty($page)):?>
<div class="wiki-footer">
	<p class="author">
		last revision by
		<strong><?php echo $page['User']['username']?></strong>
		on <?php echo date('Y-m-d', strtotime($page['Wiki']['created']));?>
	</p>
</div>
<?php endif;?>

<?php if (!empty($revisions) && !empty($page)):?>
<div class="wiki-footer revisions">
	<?php
		echo $form->create(array('url' => array('action' => 'index', $path, $slug)));
		echo $form->input('revision', array('value' => $page['Wiki']['id']));
		$buttons =
			$form->submit(__('view',true), array('div' => false, 'name' => 'view'))
			. $form->submit(__('activate',true), array('div' => false, 'name' => 'activate'));
		if (!empty($canDelete)) {
			$buttons .= $form->submit(__('delete',true), array('div' => false, 'name' => 'delete'));
		}
		echo $html->tag('div', $buttons, array('class' => 'submit'));
		echo $form->end();
	?>
</div>
<?php endif;?>

</div>

</div>
