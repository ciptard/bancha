<?php
/**
 * Blog Detail View
 *
 * Content detail - Sandbox Theme
 *
 * @package		Bancha
 * @author		Nicholas Valbusa - info@squallstar.it - @squallstar
 * @copyright	Copyright (c) 2011-2012, Squallstar
 * @license		GNU/GPL (General Public License)
 *
 */

//Here you can save a new comment when a form is posted
if ($this->input->post('message')) {
 	$comment = new Record('Comments');
 	$comment->set('content', $this->input->post('message'))
 			->set('author', $this->input->post('author'))
 			->set('date_insert', time())
 			->set('post_id', $record->id);
 	
 	//We save the comment
 	$pkey = $this->records->save($comment);

 	//And here we publish it
 	if ($pkey) {
 		$this->records->publish($pkey, 'Comments');
 	}
}

//Then we get the comments linked to the current post that we are viewing
$comments =& $record->related('comments');

?>

<article>
	<h1><?php echo page('title'); ?></h1>

	<h2><?php echo record('title'); ?></h2>
	<p><?php echo record('content'); ?></p>
</article>

<hr />

<h3><?php echo count($comments); ?> Comments</h3>
<?php
//Here we display the comments
if (is_array($comments) && count($comments)) {
	echo '<ul>';
	foreach ($comments as $comment) {
		echo '<li>' . date('d/m/Y H:i', $comment->get('date_insert'))
		   . ' by <strong>' . $comment->get('author') . '</strong>'
		   . '<p>' . $comment->get('content') . '</p></li>';
	}
	echo '</ul>';
}
?>

<hr />
<h3>Add a new comment</h3>
<form action="<?php echo current_url(); ?>" method="post">
	<fieldset>
		<label for="author">Name</label><br />
		<input type="text" id="author" name="author" /><br /><br />

		<label for="message">Message</label><br />
		<textarea id="name" name="message"></textarea><br /><br />

		<input type="submit" value="<?php echo _('Send'); ?>" />
	</fieldset>
</form>

<?php
/* End of file detail.php */
/* Location: /type_templates/Blog/detail.php */