<?php do_action('cf-cms_before_form'); ?>
<form action="" method="post">
    <?php do_action('cf-cms_before_form_field'); ?>

    <div class="form-wrapper">
        <div class="half-input">
            <label for="user_first_name"><?php _e('First Name', 'cf-cms'); ?></label>
            <input type="text" class="form-field" name="user_first_name" id="user_first_name">
        </div>
        <div class="half-input">
            <label for="user_last_name"><?php _e('Last Name', 'cf-cms'); ?></label>
            <input type="text" class="form-field" name="user_last_name" id="user_last_name">
        </div>
    </div>

    <div class="form-wrapper">
        <div class="half-input">
            <label for="user_phone"><?php _e('Phone', 'cf-cms'); ?></label>
            <input type="text" class="form-field" name="user_phone" id="user_phone">
        </div>
        <div class="half-input">
            <label for="user_email"><?php _e('Email', 'cf-cms'); ?></label>
            <input type="email" class="form-field" name="user_email" id="user_email">
        </div>
    </div>

    <div class="form-wrapper">
        <div class="full-input">
            <label for="user_comment"><?php _e('Comment', 'cf-cms'); ?></label>
            <textarea name="user_comment" id="user_comment" class="form-field"></textarea>
        </div>
    </div>

    <?php do_action('cf-cms_after_form_field'); ?>

    <div class="form-wrapper">
        <input type="submit" value="<?php _e('Save', 'cf-cms'); ?>">
    </div>
</form>
<?php do_action('cf-cms_after_form'); ?>