// Included to use openai API key 
function openai_api_key_shortcode() {
$api_key = OPENAI_API_KEY; echo '<script>
var openaiApiKey = "' . esc_js($api_key) . '";
</script>';
}
add_action('wp_footer', 'openai_api_key_shortcode');
