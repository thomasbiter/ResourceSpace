<?php /* -------- Text Box (formatted / CKeditor) ---------------- */ ?>
<br /><br />
<textarea class="stdwidth" rows=20 cols=80 name="<?php echo $name?>" id="<?php echo $name?>" <?php echo $help_js; ?>
><?php echo htmlspecialchars($value)?></textarea><?php

switch (strtolower($language))
    {
    case "en":
        # en in ResourceSpace corresponds to en-gb in CKEditor
        $ckeditor_language = "en-gb";
        break;
    case "en-us";
        # en-US in ResourceSpace corresponds to en in CKEditor
        $ckeditor_language = "en";
        break;
    default:
        $ckeditor_language = strtolower($language);
        break;
    }
?>
<script type="text/javascript">

// Replace the <textarea id=$name> with an CKEditor instance.
<?php if(!hook("ckeditorinit")): ?>
var editor = CKEDITOR.instances['<?php echo $name?>'];
if (editor) { editor.destroy(true); }
CKEDITOR.replace('<?php echo $name ?>',
    {
    language: '<?php echo $ckeditor_language ?>',
    // Define the toolbar to be used.
    toolbar : [ [ <?php global $ckeditor_toolbars;echo $ckeditor_toolbars; ?> ] ],
    height: "350"
    });
var editor = CKEDITOR.instances['<?php echo $name?>'];
<?php endif; ?>

<?php hook("ckeditoroptions"); ?>

<?php 
# Add an event handler to auto save this field if changed.
if ($edit_autosave) {?>
editor.on('blur',function(e) 
	{
	if(editor.checkDirty())
		{
		editor.updateElement();
		AutoSave('<?php echo $fields[$n]["ref"]?>');
		}
	});
<?php } ?>

</script>

