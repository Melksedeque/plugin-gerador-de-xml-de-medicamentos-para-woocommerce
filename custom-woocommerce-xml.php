<?php
/*
Plugin Name: XML personalizado para Preço Medicamentos
Description: Um plugin personalizado para gerar um XML com informações de produtos do WooCommerce para anunciar na Preço Medicamentos.
Version: 1.0
Author: Melksedeque Silva
Author email: freelancer@melksedeque.com.br
Author URI: https://github.com/Melksedeque
*/

// Define o caminho para a pasta de logs
$logPath = plugin_dir_path(__FILE__) . 'logs/';

// Certifica-se de que a pasta de logs exista
if (!file_exists($logPath)) {
    mkdir($logPath, 0755, true);
}

// Configura o PHP para registrar erros em um arquivo de log
ini_set('log_errors', 1);
ini_set('error_log', $logPath . 'php_errors.log');

// Define uma função para agendar o evento
function agendar_evento_xml_medicamentos() {
    if (!wp_next_scheduled('gerar_xml_medicamentos_evento')) {
        wp_schedule_event(time(), 'hourly', 'gerar_xml_medicamentos_evento');
    }
}

// Adiciona a ação para chamar a função de agendamento quando o WordPress é inicializado
add_action('wp', 'agendar_evento_xml_medicamentos');

// Ação para executar a função gerar_xml_medicamentos() no evento agendado
add_action('gerar_xml_medicamentos_evento', 'gerar_xml_medicamentos');

// Define o intervalo personalizado para agendamento para testes quando necessário
// function definir_intervalo_cron($schedules) {
//     $schedules['every_five_minutes'] = array(
//         'interval' => 300, // Intervalo em segundos (5 minutos = 300 segundos)
//         'display'  => __('A cada 5 minutos'),
//     );
//     return $schedules;
// }

// Adiciona o intervalo personalizado aos cron schedules disponíveis
add_filter('cron_schedules', 'definir_intervalo_cron');

function gerar_xml_medicamentos() {
    try {
        // Busca medicamentos do WooCommerce que estão publicados
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        );

        $products = new WP_Query($args);

        // Inicia a tag XML
        $xml = new SimpleXMLElement('<aliria></aliria>');

        while ($products->have_posts()) {
            $products->the_post();
            $product = wc_get_product(get_the_ID());

            // Verifica status do estoque para definir se o medicamento será anunciado na Preço Medicamentos
            $status_estoque = $product->get_stock_status();
            $preco = ($status_estoque === 'instock') ? $product->get_price() : 0;

            $productArray = json_decode($product, true);
            $gtin = '';
            // Busca o valor do EAN dentro da meta_data hwp_product_gtin
            if (isset($productArray['meta_data'])) {
                foreach ($productArray['meta_data'] as $metaItem) {
                    if (isset($metaItem['key']) && $metaItem['key'] === 'hwp_product_gtin') {
                        $gtin = $metaItem['value'];
                        break;
                    }
                }
            }

            // Adiciona medicamentos ao XML com suas tags internas
            $medicamento = $xml->addChild('medicamento');
            $medicamento->addChild('ean', $gtin);
            $medicamento->addChild('titulo', get_the_title());
            $medicamento->addChild('preco', $preco);
            $medicamento->addChild('link', get_permalink());
            $medicamento->addChild('status', $status_estoque);
        }

        // Salva XML na pasta xml na raiz do public_html dentro da pasta xml ABSPATH traz a public_html
        $xmlFilePath = ABSPATH . '/xml/aliria_medicamentos.xml';

        if ($xml->asXML($xmlFilePath)) {
            echo 'XML gerado com sucesso!<br>';
        } else {
            echo 'Erro ao gerar XML.<br>';
        }
    } catch (Exception $e) {
        // Captura exceções e registra mensagens de erro
        error_log('Erro no plugin XML Preço Medicamentos: ' . $e->getMessage(), 3, $logPath . 'plugin_errors.log');
    }
}

// Ação para o endpoint
add_action('init', function () {
    // Verifica se o parâmetro GET 'direct' existe e se o valor dele é 'true'
    if (isset($_GET['direct']) && $_GET['direct'] === 'true') {
        gerar_xml_medicamentos();
        header("Location: https://eualiria.com.br/xml/aliria_medicamentos.xml");
        exit;
    }
});
