<?php
/**
 * Theme Functions – Gurkenschau
 * Vollständige functions.php inkl. Preset-Auswahl (Standard / Herbst / Winter)
 * und Ausgabe als :root CSS-Variablen (Frontend + Block-Editor).
 *
 * Textdomain: gurkenschau
 */

// ---------------------------------------------
// Assets (Frontend + Google Fonts)
// ---------------------------------------------
function gurkenschau_enqueue_scripts() {
    // Haupt-CSS mit Cache-Busting via filemtime
    $css_file_path = get_template_directory() . '/style.css';
    $css_version   = file_exists($css_file_path) ? filemtime($css_file_path) : '1.0';

    wp_enqueue_style('gurkenschau-style', get_stylesheet_uri(), array(), $css_version);

    // Google Fonts (Versionsparam auf null lassen, damit Browser korrekt cacht)
    wp_enqueue_style(
        'gurkenschau-google-fonts',
        'https://fonts.googleapis.com/css2?family=Poppins&display=swap',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'gurkenschau_enqueue_scripts');

// ---------------------------------------------
// Theme Setup
// ---------------------------------------------
function gurkenschau_theme_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');

    // Editor-Styles aktivieren + Datei registrieren
    add_theme_support('editor-styles');
    add_editor_style('editor-style.css');

    // Responsive Embeds + Wide/Full Alignments
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
}
add_action('after_setup_theme', 'gurkenschau_theme_setup');

// ---------------------------------------------
// Gutenberg/Block-Editor – Styles laden
// ---------------------------------------------
function gurkenschau_block_editor_styles() {
    $editor_css_path = get_template_directory() . '/editor-style.css';
    $editor_version  = file_exists($editor_css_path) ? filemtime($editor_css_path) : '1.0';

    wp_enqueue_style(
        'gurkenschau-block-editor-styles',
        get_template_directory_uri() . '/editor-style.css',
        array(),
        $editor_version
    );
}
add_action('enqueue_block_editor_assets', 'gurkenschau_block_editor_styles');

// ---------------------------------------------
// Customizer: Basis-Einstellungen (Logo, Header, Navigation, News)
// ---------------------------------------------
function gurkenschau_customize_register($wp_customize) {
    // Logo
    $wp_customize->add_section('gurkenschau_logo_section', array(
        'title'    => __('Logo Einstellungen', 'gurkenschau'),
        'priority' => 30,
    ));
    $wp_customize->add_setting('gurkenschau_logo', array(
        'default'           => get_template_directory_uri() . '/assets/img/logo.png',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'gurkenschau_logo_control',
        array(
            'label'    => __('Logo Bild', 'gurkenschau'),
            'section'  => 'gurkenschau_logo_section',
            'settings' => 'gurkenschau_logo',
        )
    ));

    // Farben – Grund-Section (wird auch für Presets genutzt)
    if (!$wp_customize->get_section('gurkenschau_colors_section')) {
        $wp_customize->add_section('gurkenschau_colors_section', array(
            'title'    => __('Farben', 'gurkenschau'),
            'priority' => 40,
        ));
    }

    // Header-Einstellungen
    $wp_customize->add_section('gurkenschau_header_section', array(
        'title'    => __('Header Einstellungen', 'gurkenschau'),
        'priority' => 35,
    ));
    $wp_customize->add_setting('gurkenschau_header_button_text', array(
        'default'           => 'Weitere Informationen',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('gurkenschau_header_button_text_control', array(
        'label'    => __('Button Text', 'gurkenschau'),
        'section'  => 'gurkenschau_header_section',
        'settings' => 'gurkenschau_header_button_text',
        'type'     => 'text',
    ));

    // Navigation
    $wp_customize->add_section('gurkenschau_navigation_section', array(
        'title'    => __('Navigation Links', 'gurkenschau'),
        'priority' => 45,
    ));
    $wp_customize->add_setting('gurkenschau_search_url', array(
        'default'           => site_url('/suche'),
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('gurkenschau_search_url_control', array(
        'label'    => __('Suche URL', 'gurkenschau'),
        'section'  => 'gurkenschau_navigation_section',
        'settings' => 'gurkenschau_search_url',
        'type'     => 'url',
    ));
    $wp_customize->add_setting('gurkenschau_rechtliches_url', array(
        'default'           => site_url('/rechtliches.html'),
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('gurkenschau_rechtliches_url_control', array(
        'label'    => __('Rechtliches URL', 'gurkenschau'),
        'section'  => 'gurkenschau_navigation_section',
        'settings' => 'gurkenschau_rechtliches_url',
        'type'     => 'url',
    ));
    $wp_customize->add_setting('gurkenschau_phone_number', array(
        'default'           => '+49123456789',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('gurkenschau_phone_number_control', array(
        'label'    => __('Telefonnummer', 'gurkenschau'),
        'section'  => 'gurkenschau_navigation_section',
        'settings' => 'gurkenschau_phone_number',
        'type'     => 'tel',
    ));
    $wp_customize->add_setting('gurkenschau_email', array(
        'default'           => 'kontakt@gurkenschau.de',
        'sanitize_callback' => 'sanitize_email'
    ));
    $wp_customize->add_control('gurkenschau_email_control', array(
        'label'    => __('E-Mail Adresse', 'gurkenschau'),
        'section'  => 'gurkenschau_navigation_section',
        'settings' => 'gurkenschau_email',
        'type'     => 'email',
    ));

    // News
    $wp_customize->add_section('gurkenschau_news_section', array(
        'title'    => __('News Einstellungen', 'gurkenschau'),
        'priority' => 50,
    ));
    $wp_customize->add_setting('gurkenschau_news_title', array(
        'default'           => 'Weitere aktuelle Meldungen:',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('gurkenschau_news_title_control', array(
        'label'    => __('News Überschrift', 'gurkenschau'),
        'section'  => 'gurkenschau_news_section',
        'settings' => 'gurkenschau_news_title',
        'type'     => 'text',
    ));
    $wp_customize->add_setting('gurkenschau_posts_per_page', array(
        'default'           => 4,
        'sanitize_callback' => 'absint'
    ));
    $wp_customize->add_control('gurkenschau_posts_per_page_control', array(
        'label'       => __('Anzahl der Beiträge', 'gurkenschau'),
        'section'     => 'gurkenschau_news_section',
        'settings'    => 'gurkenschau_posts_per_page',
        'type'        => 'number',
        'input_attrs' => array('min' => 1, 'max' => 12),
    ));
}
add_action('customize_register', 'gurkenschau_customize_register');

// ---------------------------------------------
// Customizer: Farbschema-Presets (Standard / Herbst / Winter)
// ---------------------------------------------
function gurkenschau_customize_register_presets($wp_customize) {
    // Eigene Section für Presets, damit sie sicher sichtbar ist
    $section_id = 'gurkenschau_color_presets';
    if (!$wp_customize->get_section($section_id)) {
        $wp_customize->add_section($section_id, array(
            'title'    => __('Farbschema', 'gurkenschau'),
            'priority' => 41,
        ));
    }

    $wp_customize->add_setting('gurkenschau_color_preset', array(
        'default'           => 'standard',
        'sanitize_callback' => function ($value) {
            $allowed = array('standard', 'herbst', 'winter');
            return in_array($value, $allowed, true) ? $value : 'standard';
        },
        'transport'         => 'refresh', // auf Wunsch: 'postMessage' + JS-Live-Preview
    ));

    $wp_customize->add_control('gurkenschau_color_preset_control', array(
        'label'    => __('Farbschema (Preset)', 'gurkenschau'),
        'section'  => $section_id,
        'settings' => 'gurkenschau_color_preset',
        'type'     => 'radio',
        'choices'  => array(
            'standard' => __('Standard', 'gurkenschau'),
            'herbst'   => __('Herbst', 'gurkenschau'),
            'winter'   => __('Winter', 'gurkenschau'),
        ),
    ));
}
add_action('customize_register', 'gurkenschau_customize_register_presets');

// ---------------------------------------------
// Preset-Definitionen zentral bereitstellen (Filterbar)
// ---------------------------------------------
function gurkenschau_get_color_presets() {
    $presets = array(
        'herbst' => array(
            '--main-color'    => 'rgb(213,69,27)',      // Sidebar, Header
            '--akzent1-color' => 'rgb(255, 242, 0)',    // Buttons, Sidebar-Link-Hover
            '--akzent2-color' => 'rgb(255, 255, 255)',  // Hintergrund (Weiß)
            '--akzent3-color' => 'rgb(255,155,69)',     // Artikel-Karte
            '--akzent4-color' => 'rgb(199,56,12)',      // Sendungs-Karte
            '--g-start'       => 'rgba(213,69,27, 1)',
            '--g-middle'      => 'rgba(213,69,27, 0.85)',
            '--g-end'         => 'rgba(213,69,27, 0)',
        ),
        'winter' => array(
            '--main-color'    => 'rgb(83, 86, 255)',
            '--akzent1-color' => 'rgb(255, 242, 0)',
            '--akzent2-color' => 'rgb(255, 255, 255)',
            '--akzent3-color' => 'rgb(148,215,235)',
            '--akzent4-color' => 'rgb(55, 140, 231)',
            '--g-start'       => 'rgba(83, 86, 255, 1)',
            '--g-middle'      => 'rgba(83, 86, 255, 0.85)',
            '--g-end'         => 'rgba(83, 86, 255, 0)',
        ),
        'standard' => array(
            '--main-color'    => 'rgb(12, 126, 164)',
            '--akzent1-color' => 'rgb(255, 242, 0)',
            '--akzent2-color' => 'rgb(255, 255, 255)',
            '--akzent3-color' => 'rgb(255, 235, 0)',
            '--akzent4-color' => 'rgb(0, 212, 255)',
            '--g-start'       => 'rgba(12, 126, 164, 1)',
            '--g-middle'      => 'rgba(12, 126, 165, 0.85)',
            '--g-end'         => 'rgba(12, 126, 164, 0)',
        ),
    );

    /**
     * Filter: gurkenschau_color_presets
     * Erlaubt das Erweitern/Überschreiben der Presets von Child-Themes/Plugins.
     */
    return apply_filters('gurkenschau_color_presets', $presets);
}

// ---------------------------------------------
// Ausgabe der :root CSS-Variablen (Frontend)
// ---------------------------------------------
function gurkenschau_output_preset_css_vars() {
    $preset_key = get_theme_mod('gurkenschau_color_preset', 'standard');
    $presets    = gurkenschau_get_color_presets();
    $vars       = isset($presets[$preset_key]) ? $presets[$preset_key] : $presets['standard'];

    $declarations = '';
    foreach ($vars as $k => $v) {
        $declarations .= sprintf('%s:%s;', $k, esc_html($v));
    }

    $css = ":root{%s}";
    $css = sprintf($css, $declarations);

    // Hinter das Haupt-Stylesheet hängen, damit es Variablen-Defaults überschreibt
    wp_add_inline_style('gurkenschau-style', $css);
}
add_action('wp_enqueue_scripts', 'gurkenschau_output_preset_css_vars', 20);

// ---------------------------------------------
// Ausgabe der :root CSS-Variablen (Block-Editor)
// ---------------------------------------------
function gurkenschau_output_preset_css_vars_editor() {
    $preset_key = get_theme_mod('gurkenschau_color_preset', 'standard');
    $presets    = gurkenschau_get_color_presets();
    $vars       = isset($presets[$preset_key]) ? $presets[$preset_key] : $presets['standard'];

    $declarations = '';
    foreach ($vars as $k => $v) {
        $declarations .= sprintf('%s:%s;', $k, esc_html($v));
    }

    $css = ":root{%s}";
    $css = sprintf($css, $declarations);

    // An das Editor-Stylesheet koppeln
    wp_add_inline_style('gurkenschau-block-editor-styles', $css);
}
add_action('enqueue_block_editor_assets', 'gurkenschau_output_preset_css_vars_editor', 20);
// ---------------------------------------------
// Emoji-Presets (Seitenleiste) – Definition + Filter
// ---------------------------------------------
function gurkenschau_get_emoji_presets() {
    $presets = array(
        'standard' => '🥒', // Gurkenschau ;)
        'herbst'   => '🍂',
        'winter'   => '❄️',
    );

    /**
     * Filter erlaubt Erweitern/Ändern der Emoji-Presets:
     * add_filter('gurkenschau_emoji_presets', function($presets){
     *     $presets['sommer'] = '🌞';
     *     return $presets;
     * });
     */
    return apply_filters('gurkenschau_emoji_presets', $presets);
}

// ---------------------------------------------
// Customizer: Emoji-Auswahl (koppelbar ans Farbschema)
// ---------------------------------------------
add_action('customize_register', function($wp_customize) {
    // in bestehender Farbschema-Section anzeigen (aus deiner Datei: 'gurkenschau_color_presets')
    $section_id = 'gurkenschau_color_presets';
    if (!$wp_customize->get_section($section_id)) {
        // Fallback, falls Section anders heißt
        $section_id = 'gurkenschau_colors_section';
    }

    // Setting: Wie wird das Emoji gewählt?
    $wp_customize->add_setting('gurkenschau_emoji_preset', array(
        'default'           => 'inherit', // folgt dem Farbschema
        'sanitize_callback' => function($v){
            $allowed = array_merge(array('inherit','custom'), array_keys(gurkenschau_get_emoji_presets()));
            return in_array($v, $allowed, true) ? $v : 'inherit';
        },
        'transport'         => 'refresh',
    ));

    // Control: Auswahl
    $choices = array('inherit' => __('Mit Farbschema koppeln', 'gurkenschau'));
    foreach (gurkenschau_get_emoji_presets() as $key => $emoji) {
        $label = ucfirst($key) . " $emoji";
        $choices[$key] = $label;
    }
    $choices['custom'] = __('Eigenes Emoji …', 'gurkenschau');

    $wp_customize->add_control('gurkenschau_emoji_preset_control', array(
        'label'    => __('Sidebar-Emoji', 'gurkenschau'),
        'section'  => $section_id,
        'settings' => 'gurkenschau_emoji_preset',
        'type'     => 'select',
        'choices'  => $choices,
    ));

    // Setting + Control: eigenes Emoji (nur genutzt, wenn Auswahl = "custom")
    $wp_customize->add_setting('gurkenschau_emoji_custom', array(
        'default'           => '',
        'sanitize_callback' => function($v){
            // einfache Sanitization; Emojis können mehrere Codepoints sein -> nicht zu hart beschneiden
            $v = wp_strip_all_tags($v);
            return mb_substr($v, 0, 8); // Safety cutoff
        },
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('gurkenschau_emoji_custom_control', array(
        'label'       => __('Eigenes Emoji eingeben', 'gurkenschau'),
        'description' => __('Wird nur verwendet, wenn oben „Eigenes Emoji …“ gewählt ist.', 'gurkenschau'),
        'section'     => $section_id,
        'settings'    => 'gurkenschau_emoji_custom',
        'type'        => 'text',
        'input_attrs' => array(
            'placeholder' => '✨',
            'style'       => 'width:100px;text-align:center;font-size:22px;',
        ),
    ));
});

// ---------------------------------------------
// Helper: Effektiv verwendetes Sidebar-Emoji ermitteln
// ---------------------------------------------
function gurkenschau_get_sidebar_emoji() {
    $mode       = get_theme_mod('gurkenschau_emoji_preset', 'inherit');
    $color_preset = get_theme_mod('gurkenschau_color_preset', 'standard');
    $emoji_map  = gurkenschau_get_emoji_presets();

    if ($mode === 'custom') {
        $custom = get_theme_mod('gurkenschau_emoji_custom', '');
        return $custom !== '' ? $custom : '📰'; // Fallback
    }

    // 'inherit' => benutze Emoji passend zum aktuellen Farbschema
    $key = ($mode === 'inherit') ? $color_preset : $mode;

    if (isset($emoji_map[$key])) {
        return $emoji_map[$key];
    }

    // Fallback, wenn nichts passt
    return isset($emoji_map['standard']) ? $emoji_map['standard'] : '📰';
}

// ---------------------------------------------
// Shortcode für Widgets/Blöcke: [gurkenschau_emoji]
// ---------------------------------------------
add_shortcode('gurkenschau_emoji', function() {
    return esc_html( gurkenschau_get_sidebar_emoji() );
});

add_filter('gurkenschau_emoji_presets', function($presets){
    $presets['sommer'] = '🌞';
    $presets['fruehling'] = '🌷';
    $presets['news'] = '🗞️';
	$presets['neujahr'] = '🎆';
	$presets['Halloween'] = '🎃';
	$presets['Weihnachten'] = '🎄';
    return $presets;
});
// ---------------------------------------------
// Anzeige einer Emoji-Datumsliste unter dem Eingabefeld
// ---------------------------------------------
add_action('customize_register', function($wp_customize) {
    // Section wie zuvor
    $section_id = 'gurkenschau_color_presets';
    if (!$wp_customize->get_section($section_id)) {
        $section_id = 'gurkenschau_colors_section';
    }

    // Beispielhafte Datum-Emoji-Liste (kannst du beliebig erweitern)
    $date_emojis = array(
        '🎆' => '01. Januar – Neujahr',
        '🌸' => '21. März – Frühlingsanfang',
        '🐰' => 'März/April – Ostern',
        '🎂' => 'Persönliche Geburtstage',
        '☀️' => '21. Juni – Sommeranfang',
        '🎃' => '31. Oktober – Halloween',
        '🕯️' => '11. November – Martinstag',
        '🎄' => '24.–26. Dezember – Weihnachten',
        '🎆' => '31. Dezember – Silvester',
    );

    // HTML-Tabelle generieren
    $html = '<div style="margin-top:10px;padding:8px;border:1px solid #ddd;border-radius:6px;background:#fff;">';
    $html .= '<strong>' . __('Beispielhafte Emojis nach Datum', 'gurkenschau') . ':</strong><br><table style="width:100%;border-collapse:collapse;margin-top:5px">';
    foreach ($date_emojis as $emoji => $label) {
        $html .= '<tr><td style="width:40px;text-align:center;font-size:20px;">' . esc_html($emoji) . '</td><td>' . esc_html($label) . '</td></tr>';
    }
    $html .= '</table>';
    $html .= '<p style="margin-top:6px;font-size:12px;color:#555;">' . __('Diese Liste ist nur eine Inspiration – du kannst jedes beliebige Emoji eingeben.', 'gurkenschau') . '</p>';
	$html .= '<a href="https://emojipedia.org" target="_blank">' . __('https://emojipedia.org ist dein Freund.', 'gurkenschau') . '</a>';
    $html .= '</div>';

    // Dummy-Setting (nur Anzeige)
    $wp_customize->add_setting('gurkenschau_emoji_info', array(
        'sanitize_callback' => '__return_empty_string',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'gurkenschau_emoji_info_control', array(
        'section'     => $section_id,
        'settings'    => 'gurkenschau_emoji_info',
        'type'        => 'hidden',
        'description' => $html,
    )));
});

// ---------------------------------------------
// Video-Block: Download/Playback-Optionen entfernen
// ---------------------------------------------
add_filter('render_block', 'wd_video_block_render', 10, 2);
function wd_video_block_render($output, $block) {
    if (!isset($block['blockName']) || 'core/video' !== $block['blockName']) {
        return $output;
    }

    // controlslist + disablePictureInPicture ergänzen
    $output = str_replace(
        '<video controls',
        '<video controls controlslist="nodownload noplaybackrate noremoteplayback" disablePictureInPicture',
        $output
    );

    return $output;
}
