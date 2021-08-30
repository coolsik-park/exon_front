
<section>
	<?php foreach ($banner as $list): ?>

		<article>
			<!-- Use the HtmlHelper to create a link -->
			<h4><?= $this->Html->link(
				$list->_matchingData['Exhibition']->title,
				['controller' => 'Users', 'action' => 'view', $list->id]
			) ?></h4>
			<img src="<?php echo $list->img_path . $list->img_name;?>">
		</article>
	<?php endforeach; ?>
</section>
