<?php

namespace MediaCredits\Modules;


class Main
{
    const SLUG_SOURCE_TITLE = 'mc-source-title';
    const SLUG_SOURCE_URL   = 'mc-source-url';
    const SLUG_AUTHOR       = 'mc-author';
    const SLUG_AUTHOR_URL   = 'mc-author-url';
    const SLUG_LICENSE      = 'mc-license';

    public static function init()
    {
        add_action( 'init', array(__CLASS__, 'wp_init') );

        add_filter( 'attachment_fields_to_edit', array(__CLASS__, 'attachment_fields_edit'), 10, 2 );
        add_filter( 'attachment_fields_to_save', array(__CLASS__, 'attachment_fields_save'), 10, 2 );
    }

    public static function wp_init()
    {
        load_textdomain(
            MC_TEXT_DOMAIN,
            MC_ROUTE_DIR . "/languages/" . get_locale() . ".mo"
        );
    }

    public static function get_license_types()
    {
        return array(
            'cc-by-2.0' => array (
                'label'     => 'CC BY 2.0',
                'fullname'  => 'Attribution 2.0 Generic',
                'deed'      => 'http://creativecommons.org/licenses/by/2.0/',
                'default'   => true
            ),
            'cc-by' => array (
                'label'     => 'CC BY',
                'fullname'  => 'Attribution 4.0 International',
                'deed'      => 'http://creativecommons.org/licenses/by/4.0/'
            ),
        );
    }

    public static function attachment_fields_edit( $form_fields, $post )
    {
        $form_fields[self::SLUG_SOURCE_TITLE] = array(
            'label' => __('Original Title', MC_TEXT_DOMAIN),
            'input' => 'text',
            'value' => get_post_meta( $post->ID, self::SLUG_SOURCE_TITLE, true ),
            'helps' => __('The original title of the media object', MC_TEXT_DOMAIN),
        );

        $form_fields[self::SLUG_SOURCE_URL] = array(
            'label' => __('Source Link', MC_TEXT_DOMAIN),
            'input' => 'text',
            'value' => get_post_meta( $post->ID, self::SLUG_SOURCE_URL, true ),
            'helps' => __('Link to the original image', MC_TEXT_DOMAIN),
        );

        $form_fields[self::SLUG_AUTHOR] = array(
            'label' => __('Author', MC_TEXT_DOMAIN),
            'input' => 'text',
            'value' => get_post_meta( $post->ID, self::SLUG_AUTHOR, true ),
            'helps' => __('Name of the author', MC_TEXT_DOMAIN),
        );

        $form_fields[self::SLUG_AUTHOR_URL] = array(
            'label' => __('Author Profile Link', MC_TEXT_DOMAIN),
            'input' => 'text',
            'value' => get_post_meta( $post->ID, self::SLUG_AUTHOR_URL, true ),
            'helps' => __('Link to the author\'s profile page', MC_TEXT_DOMAIN),
        );


        //get license options
        $license_options = '';

        $license_value = get_post_meta( $post->ID, self::SLUG_LICENSE, true );

        foreach( self::get_license_types() as $id => $license )
        {
            $license_options .=
                "<option value='{$id}' " .
                    selected( $license_value == $id || (!$license_value && $license['default']), true, false) .
                    ">{$license['label']} ({$license['fullname']})" .
                "</option>";
        }

        $form_fields[self::SLUG_LICENSE] = array(
            'label' => __('License', MC_TEXT_DOMAIN),
            'input' => 'html',
            'helps' => __('Select the license under which the image can be used', MC_TEXT_DOMAIN),
            'html'  => "
                <select name='attachments[{$post->ID}][".self::SLUG_LICENSE."]'
                        id='attachments[{$post->ID}][".self::SLUG_LICENSE."]'>" .
                    $license_options .
                "</select>"
        );

        return $form_fields;
    }

    public static function attachment_fields_save( $post, $attachment )
    {
        //Text fields
        foreach( array(self::SLUG_SOURCE_TITLE, self::SLUG_AUTHOR) as $field_slug )
        {
            if( isset( $attachment[$field_slug] ) )
                update_post_meta( $post['ID'], $field_slug, sanitize_text_field($attachment[$field_slug]) );
        }

        //Url fields
        foreach( array(self::SLUG_SOURCE_URL, self::SLUG_AUTHOR_URL) as $field_slug )
        {
            if( isset( $attachment[$field_slug] ) )
                update_post_meta( $post['ID'], $field_slug, esc_url($attachment[$field_slug]) );
        }

        //License field
        if( isset( $attachment[self::SLUG_LICENSE] ) && array_key_exists($attachment[self::SLUG_LICENSE], self::get_license_types()) )
            update_post_meta( $post['ID'], self::SLUG_LICENSE, $attachment[self::SLUG_LICENSE] );

        return $post;
    }

    public static function get_license_info( $attachment_id )
    {
        return array(
            self::SLUG_SOURCE_TITLE => get_post_meta($attachment_id, self::SLUG_SOURCE_TITLE, true),
            self::SLUG_SOURCE_URL   => get_post_meta($attachment_id, self::SLUG_SOURCE_URL, true),
            self::SLUG_AUTHOR       => get_post_meta($attachment_id, self::SLUG_AUTHOR, true),
            self::SLUG_AUTHOR_URL   => get_post_meta($attachment_id, self::SLUG_AUTHOR_URL, true),
            self::SLUG_LICENSE      => self::get_license_types()[get_post_meta($attachment_id, self::SLUG_LICENSE, true)],
        );
    }

    public static function license_info( $attachment_id, $args = array() )
    {
        $args = wp_parse_args( $args, array(
            'format' => 'one-line',
            'echo'   => true
        ));

        $info = self::get_license_info( $attachment_id );

        if( !$args['echo'] )
            ob_start();

        ?>
        <span id="mc-license-info-<?php echo $attachment_id ?>" class="mc-license-info">

            <span class="mc-title">

                 <?php if( $info[self::SLUG_SOURCE_URL] ) : ?>
                    <a href="<?php echo $info[self::SLUG_SOURCE_URL] ?>" target="_blank">
                 <?php endif ?>

                 <?php echo $info[self::SLUG_SOURCE_TITLE] ? $info[self::SLUG_SOURCE_TITLE] : get_the_title($attachment_id) ?><?php echo ($info[self::SLUG_SOURCE_URL] ? '</a>' : '') ?>

            </span>

            <?php if( $info[self::SLUG_AUTHOR] ) : ?>
                <span class="mc-author">
                    <?php _e('by', MC_TEXT_DOMAIN) ?>

                    <?php if( $info[self::SLUG_AUTHOR_URL] ) : ?>
                        <a href="<?php $info[self::SLUG_AUTHOR_URL] ?>" target="_blank">
                    <?php endif ?>

                    <?php echo $info[self::SLUG_AUTHOR] ?><?php echo ($info[self::SLUG_AUTHOR_URL] ? '</a>' : '') ?>
                </span>
            <?php endif ?>

            <?php if( $info[self::SLUG_LICENSE] ) : ?>
                <span class="mc-license">
                    <?php _e('is licensed under', MC_TEXT_DOMAIN) ?>

                    <a href="<?php echo $info[self::SLUG_LICENSE]['deed'] ?>" target="_blank">
                        <?php echo $info[self::SLUG_LICENSE]['label'] ?>
                    </a>
                </span>
            <?php endif ?>

        </span>
        <?php

        if( !$args['echo'] )
            return ob_get_clean();

        return true;
    }
}