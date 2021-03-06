<div id="snavi">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Sprint', true)), array('action' => 'add')); ?></li>
	</ul>
</div>

<script type="text/javascript">
<!--
jQuery(document).ready(function()
{
    jQuery('#sprint_table').flexigrid({height:'auto',striped:true});
}
);
-->
</script>


<div class="sprints index">
	<h2><?php __('Sprints');?></h2>
	<table cellpadding="0" cellspacing="0" id="sprint_table">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo __('Total Story Point', true);?></th>
			<th><?php echo $this->Paginator->sort('startdate');?></th>
			<th><?php echo $this->Paginator->sort('enddate');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('updated');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($sprints as $sprint):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $sprint['Sprint']['id']; ?>&nbsp;</td>
		<td><?php echo $this->Html->link($sprint['Sprint']['name'], array('controller' => 'sprints', 'action' => 'view', $sprint['Sprint']['id'])); ?>&nbsp;</td>
		<td><?php echo nl2br(h($sprint['Sprint']['description'])); ?>&nbsp;</td>
		<?php
		$total_story_point = 0;
		foreach($sprint["Story"] as $story)
		{
			$total_story_point += $story["storypoints"];
		}
		?>
		<td><?php echo $total_story_point; ?></td>
		<td><?php echo $sprint['Sprint']['startdate']; ?>&nbsp;</td>
		<td><?php echo $sprint['Sprint']['enddate']; ?>&nbsp;</td>
		<td><?php echo date('Y-m-d', strtotime($sprint['Sprint']['created'])); ?>&nbsp;</td>
		<td><?php echo date('Y-m-d', strtotime($sprint['Sprint']['updated'])); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link($html->image('detail.png'), array('action' => 'view', $sprint['Sprint']['id']), array('escape' => false)); ?>
			<?php echo $this->Html->link($html->image('edit.png'), array('action' => 'edit', $sprint['Sprint']['id']), array('escape' => false)); ?>
			<?php echo $this->Html->link($html->image('delete.png'), array('action' => 'delete', $sprint['Sprint']['id'], '?' => array('return_url' => urlencode($html->url('/sprints/')))), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $sprint['Sprint']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
