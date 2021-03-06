<?php defined('C5_EXECUTE') or die(_("Access Denied."));

$dh = Loader::helper('concrete/dashboard');
$ih = Loader::helper('concrete/interface');
$form = Loader::helper('form');

Loader::element('editor_config'); //for wysiwyg editor
$al = Loader::helper('concrete/asset_library'); //for image chooser

$is_new = empty($id);
$heading = ($is_new ? 'Add New' : 'Edit') . ' Car';
$action = $is_new ? $this->action('add', $body_type_id) : $this->action('edit', (int)$id);
?>

<?php echo $dh->getDashboardPaneHeaderWrapper($heading); ?>

	<form method="post" action="<?php echo $action; ?>">
		<?php echo $token; ?>
		<?php echo $form->hidden('id', (int)$id); /* redundant, but simplifies processing */ ?>
		
		<table class="form-table">
			<tr>
				<td class="right"><?php echo $form->label('body_type_id', 'Body Type:'); ?></td>
				<td><?php echo $form->select('body_type_id', $body_type_options, $body_type_id); ?></td>
			</tr>
			
			<tr>
				<td class="right"><?php echo $form->label('manufacturer_id', 'Manufacturer:'); ?></td>
				<td><?php echo $form->select('manufacturer_id', $manufacturer_options, $manufacturer_id); ?></td>
			</tr>
			
			<tr>
				<td class="right"><?php echo $form->label('year', 'Model Year:'); ?></td>
				<td>
					<?php echo $form->text('year', htmlentities($year), array('maxlength' => '4', 'class' => 'input-mini')); ?>
					<i>4-digit year</i>
				</td>
			</tr>

			<tr>
				<td class="right"><?php echo $form->label('name', 'Name:'); ?></td>
				<td><?php echo $form->text('name', htmlentities($name), array('maxlength' => '255')); ?></td>
			</tr>
			
	<tr><td colspan="2"><hr></td></tr>

			<tr>
				<td>&nbsp;</td>
				<td><h2>Description</h2></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<?php Loader::element('editor_controls'); ?>
					<?php echo $form->textarea('description', $description, array('class' => 'ccm-advanced-editor')); ?>
				</td>
			</tr>
		
			<tr>
				<td class="right"><?php echo $form->label('photo_fID', 'Photo:'); ?></td>
				<td>
					<?php
					$file = empty($photo_fID) ? null : File::getByID($photo_fID);
					echo $al->image('photo_fID', 'photo_fID', 'Photo', $file);
					?>
				</td>
			</tr>
			
			<tr>
				<td class="right"><?php echo $form->label('price', 'Price:'); ?></td>
				<td>
					<div class="input-prepend">
						<span class="add-on">$</span><?php /* <-- no whitespace between <span> and <input>! */
						echo $form->text('price', number_format($price, 2), array('class' => 'input-small'));
						?>
					</div>
				</td>
			</tr>
			
	<tr><td colspan="2"><hr></td></tr>
		
			<tr>
				<td>&nbsp;</td>
				<td><h2>Colors</h2></td>
			</tr>
			
			<tr>
				<td>&nbsp;</td>
				<td>
					<?php foreach ($colors as $color): ?>
					<label class="checkbox">
						<input type="checkbox" name="color_ids[]" value="<?php echo $color['id']; ?>" <?php echo $color['has'] ? 'checked="checked"' : ''; ?>>
						<?php echo htmlentities($color['name']); ?>
					</label>
					<?php endforeach; ?>
				</td>
			</tr>

	<tr><td colspan="2"><hr></td></tr>

			<tr>
				<td class="right">&nbsp;</td>
				<td>
					<?php echo $ih->submit('Save', false, false, 'primary'); ?>
					&nbsp;&nbsp;&nbsp;
					<?php echo $ih->button('Cancel', $this->action("view?type={$body_type_id}"), false); ?>
				</td>
			</tr>
			
		</table>
	</form>
	
<?php echo $dh->getDashboardPaneFooterWrapper(); ?>
