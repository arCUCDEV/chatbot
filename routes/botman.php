<?php
use App\Http\Controllers\BotManController;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use App\Models\Conversation;
use BotMan\BotMan\BotMan;


$botman = resolve('botman');


//Añade en las demas respuestas las historias, lo de las variables de sesión

$mainMenu = function($bot) {

    $question = Question::create('¡Hola! ¿Cómo puedo ayudarte hoy?')
        ->fallback('Unable to create a new database')
        ->callbackId('ask_reason')
        ->addButtons([
            Button::create('¿Cuánto es el costo de envío?')->value('shipping_cost'),
            Button::create('¿A qué países hace envíos?')->value('shipping_countries'),
            Button::create('¿Cuáles son los métodos de pago disponibles?')->value('payload'),
            Button::create('¿Tienen promociones o descuentos especiales en este momento?')->value('onsale'),
            Button::create('Recomiéndame productos')->value('product_recommendation'),
            Button::create('Rastrear mi pedido')->value('track_order'),
            
        ]);

    $history = session('history', []);
    $history[] = 'Usuario: ' . '¡Hola! ¿Cómo puedo ayudarte hoy?';
    session(['history' => $history]);

    $bot->reply($question);
};

$botman->hears('main_menu', $mainMenu);

/* ------------------------------ COSTO DE ENVIO ----------------------------- */

$botman->hears('shipping_cost', function($bot) {
    $history = session('history', []);
    $history[] = 'Usuario: ' . '¿Cuánto es el costo de envío?';
    session(['history' => $history]);

    $question = Question::create('El costo de envío depende del país de destino. ¿A qué país se enviará tu pedido?')
        ->fallback('Unable to ask question')
        ->callbackId('ask_country')
        ->addButtons([
            Button::create('España')->value('spain'),
            Button::create('México')->value('mexico'),
            Button::create('Argentina')->value('argentina'),
            // Aquí puedes agregar más botones para otros países
        ]);

    $history = session('history', []);
    $history[] = 'Bot: ' . 'El costo de envío depende del país de destino. ¿A qué país se enviará tu pedido?';
    session(['history' => $history]);

    $bot->reply($question);
});



$botman->hears('spain', function($bot) {

    $history = session('history', []);
    $history[] = 'Usuario: ' . '¿Cual es el costo de envio a España?';
    session(['history' => $history]);

    $question = Question::create('El costo de envío a España es de 10 euros. ¿Necesitas ayuda con algo más?')
        ->fallback('Unable to ask question')
        ->callbackId('ask_more')
        ->addButtons([
            Button::create('Sí, por favor')->value('main_menu'),
            Button::create('No, gracias')->value('end_conversation'), 
        ]);

        
    $history = session('history', []);
    $history[] = 'Bot: ' . 'El costo de envío a España es de 10 euros. ¿Necesitas ayuda con algo más?';
    session(['history' => $history]);


    $bot->reply($question);
});


$botman->hears('mexico', function($bot) {
    $history = session('history', []);
    $history[] = 'Usuario: ' . '¿Cual es el costo de envio a Mexico?';
    session(['history' => $history]);

    $question = Question::create('El costo de envío a México es de 50 pesos. ¿Necesitas ayuda con algo más?')
        ->fallback('Unable to ask question')
        ->callbackId('ask_more')
        ->addButtons([
            Button::create('Sí, por favor')->value('main_menu'),
            Button::create('No, gracias')->value('end_conversation'), 
        ]);

        
    $history = session('history', []);
    $history[] = 'Bot: ' . 'El costo de envío a México es de 50 pesos. ¿Necesitas ayuda con algo más?';
    session(['history' => $history]);


    $bot->reply($question);
});

$botman->hears('argentina', function($bot) {
    $history = session('history', []);
    $history[] = 'Usuario: ' . '¿Cual es el costo de envio a Argentina?';
    session(['history' => $history]);

    $question = Question::create('El costo de envío a Argentina es de 500 pesos. ¿Necesitas ayuda con algo más?')
        ->fallback('Unable to ask question')
        ->callbackId('ask_more')
        ->addButtons([
            Button::create('Sí, por favor')->value('main_menu'),
            Button::create('No, gracias')->value('end_conversation'), 
        ]);

        
    $history = session('history', []);
    $history[] = 'Bot: ' . 'El costo de envío a Argentina es de 500 pesos. ¿Necesitas ayuda con algo más?';
    session(['history' => $history]);


    $bot->reply($question);
});


/* -------------------------------------------------------------------- */



/* --------------------------------- PROMOCIONES ---------------------- */



$botman->hears('onsale', function($bot) {
    $history = session('history', []);
    $history[] = 'Usuario: ' . '¿Cuales son las promociones';
    session(['history' => $history]);

    $question = Question::create('Las promociones de primavera son un 10% de descuento en electro domesticos, ¿Necesitas ayuda con algo mas?')
        ->fallback('Unable to ask question')
        ->callbackId('ask_more')
        ->addButtons([
            Button::create('Sí, por favor')->value('main_menu'),
            Button::create('No, gracias')->value('end_conversation'), 
        ]);

        
    $history = session('history', []);
    $history[] = 'Bot: ' . 'Las promociones de primavera son un 10% de descuento en electro domesticos, ¿Necesitas ayuda con algo mas?';
    session(['history' => $history]);


    $bot->reply($question);
});




/* -------------------------------------------------------------------- */





/* --------------------- COSTO DE ENVIÓ A PAISES -------------------------- */


$botman->hears('shipping_countries', function($bot) {

    $history = session('history', []);
    $history[] = 'Usuario: ' . '¿A cuales paises hacen envios?';
    session(['history' => $history]);

    $question = Question::create('Hacemos envíos a los siguientes países: España, México, Argentina. ¿Necesitas información sobre los costos de envío a alguno de estos países?')
        ->fallback('Unable to ask question')
        ->callbackId('ask_shipping_country')
        ->addButtons([
            Button::create('España')->value('spain'),
            Button::create('México')->value('mexico'),
            Button::create('Argentina')->value('argentina'),
            Button::create('Volver al menú principal')->value('main_menu'), 
            
        ]);

        $history = session('history', []);
        $history[] = 'Bot: ' . 'Hacemos envíos a los siguientes países: España, México, Argentina. ¿Necesitas información sobre los costos de envío a alguno de estos países?';
        session(['history' => $history]);

    $bot->reply($question);
});


/* -------------------------------------------------------------------- */


/* ------------------------- RECOMENDACION DE PRODUCTOS --------------------------- */

$botman->hears('product_recommendation', function($bot) {

    $history = session('history', []);
    $history[] = 'Usuario: ' . '¡Claro! ¿Qué tipo de productos estás buscando?';
    session(['history' => $history]);

    $question = Question::create('¡Claro! ¿Qué tipo de productos estás buscando?')
        ->fallback('Unable to ask question')
        ->callbackId('ask_product_type')
        ->addButtons([
            Button::create('Audio visual')->value('visual'),
            Button::create('Computadoras')->value('computadoras'),
            Button::create('Electrónica de Consumo')->value('electronica_consumo'),
            Button::create('Fotografía')->value('fotografia'),
            Button::create('Hogar Inteligente')->value('hogar_inteligente'),
            Button::create('Electrodomésticos')->value('electrodomesticos'),
            Button::create('Gaming')->value('gaming'),
            Button::create('Wearables')->value('wearables'),
            Button::create('Accesorios Electrónicos')->value('accesorios_electronicos'),
            Button::create('Instrumentos Musicales')->value('instrumentos_musicales')
            
        ]);
    
    $bot->reply($question);
});

$botman->hears('audio', function($bot) {

    $history = session('history', []);
    $history[] = 'Usuario: ' . 'Audio';
    session(['history' => $history]);

    $question = Question::create('Claro, estos son nuestros productos de audio: Producto A, Producto B, Producto C, ¿Necesitas ayuda con algo más?')
        ->fallback('Unable to ask question')
        ->callbackId('ask_more')
        ->addButtons([
            Button::create('Sí, por favor')->value('main_menu'),
            Button::create('No, gracias')->value('end_conversation'), 
        ]);

        
    $history = session('history', []);
    $history[] = 'Bot: ' . 'Claro, estos son nuestros productos de audio: Producto A, Producto B, Producto C, ¿Necesitas ayuda con algo más?';
    session(['history' => $history]);


    $bot->reply($question);
});

$botman->hears('visual', function($bot) {
    $products = DB::table('products')->where('categoria', 'visual')->get();
    
    $history = session('history', []);
    $history[] = 'Usuario: ' . 'visual';
    session(['history' => $history]);

    $bot->reply('Claro, estos son nuestros productos de visual:');

    foreach ($products as $product) {

        $bot->reply("Producto: " . $product->description . " - Price: $" . $product->precio . "<img src='" . $product->img_url . "' style='width: 100px; height: 100px;' alt='producto'>");

        $question = Question::create('¿Deseas agregar este producto a tu carrito de compras?')
            ->fallback('Unable to ask question')
            ->callbackId('add_to_cart')
            ->addButtons([
                Button::create('Sí, por favor')->value('add_' . $product->id_products),
                Button::create('No, gracias')->value('no_add'), 
            ]);

        $bot->reply($question);
    }
    
    $question = Question::create('¿Necesitas ayuda con algo más?')
        ->fallback('Unable to ask question')
        ->callbackId('ask_more')
        ->addButtons([
            Button::create('Sí, por favor')->value('main_menu'),
            Button::create('No, gracias')->value('end_conversation'), 
        ]);

    $history = session('history', []);
    $history[] = 'Bot: ' . '¿Necesitas ayuda con algo más?';
    session(['history' => $history]);

    $bot->reply($question);
});



$botman->hears('computadoras', function($bot) {

    $history = session('history', []);
    $history[] = 'Usuario: ' . 'computadoras';
    session(['history' => $history]);

    $question = Question::create('Claro, estos son nuestros productos de computadoras: Producto A, Producto B, Producto C, ¿Necesitas ayuda con algo más?')
        ->fallback('Unable to ask question')
        ->callbackId('ask_more')
        ->addButtons([
            Button::create('Sí, por favor')->value('main_menu'),
            Button::create('No, gracias')->value('end_conversation'), 
        ]);

        
    $history = session('history', []);
    $history[] = 'Bot: ' . 'Claro, estos son nuestros productos de computadoras: Producto A, Producto B, Producto C, ¿Necesitas ayuda con algo más?';
    session(['history' => $history]);


    $bot->reply($question);
});

$botman->hears('electronica_consumo', function($bot) {
    $history = session('history', []);
    $history[] = 'Usuario: ' . 'electronica_consumo';
    session(['history' => $history]);

    $question = Question::create('Claro, estos son nuestros productos de electronica_consumo: Producto A, Producto B, Producto C, ¿Necesitas ayuda con algo más?')
        ->fallback('Unable to ask question')
        ->callbackId('ask_more')
        ->addButtons([
            Button::create('Sí, por favor')->value('main_menu'),
            Button::create('No, gracias')->value('end_conversation'), 
        ]);

        
    $history = session('history', []);
    $history[] = 'Bot: ' . 'Claro, estos son nuestros productos de electronica_consumo: Producto A, Producto B, Producto C, ¿Necesitas ayuda con algo más?';
    session(['history' => $history]);


    $bot->reply($question);
});

$botman->hears('hogar_inteligente', function($bot) {
    $history = session('history', []);
    $history[] = 'Usuario: ' . 'hogar_inteligente';
    session(['history' => $history]);

    $question = Question::create('Claro, estos son nuestros productos de hogar_inteligente: Producto A, Producto B, Producto C, ¿Necesitas ayuda con algo más?')
        ->fallback('Unable to ask question')
        ->callbackId('ask_more')
        ->addButtons([
            Button::create('Sí, por favor')->value('main_menu'),
            Button::create('No, gracias')->value('end_conversation'), 
        ]);

        
    $history = session('history', []);
    $history[] = 'Bot: ' . 'Claro, estos son nuestros productos de hogar_inteligente: Producto A, Producto B, Producto C, ¿Necesitas ayuda con algo más?';
    session(['history' => $history]);


    $bot->reply($question);
});

$botman->hears('electrodomesticos', function($bot) {
    $history = session('history', []);
    $history[] = 'Usuario: ' . 'electrodomesticos';
    session(['history' => $history]);

    $question = Question::create('Claro, estos son nuestros productos de electrodomesticos: Producto A, Producto B, Producto C, ¿Necesitas ayuda con algo más?')
        ->fallback('Unable to ask question')
        ->callbackId('ask_more')
        ->addButtons([
            Button::create('Sí, por favor')->value('main_menu'),
            Button::create('No, gracias')->value('end_conversation'), 
        ]);

        
    $history = session('history', []);
    $history[] = 'Bot: ' . 'Claro, estos son nuestros productos de electrodomesticos: Producto A, Producto B, Producto C, ¿Necesitas ayuda con algo más?';
    session(['history' => $history]);


    $bot->reply($question);
});

$botman->hears('gaming', function($bot) {
    $history = session('history', []);
    $history[] = 'Usuario: ' . 'gaming';
    session(['history' => $history]);

    $question = Question::create('Claro, estos son nuestros productos de gaming: Producto A, Producto B, Producto C, ¿Necesitas ayuda con algo más?')
        ->fallback('Unable to ask question')
        ->callbackId('ask_more')
        ->addButtons([
            Button::create('Sí, por favor')->value('main_menu'),
            Button::create('No, gracias')->value('end_conversation'), 
        ]);

        
    $history = session('history', []);
    $history[] = 'Bot: ' . 'Claro, estos son nuestros productos de gaming: Producto A, Producto B, Producto C, ¿Necesitas ayuda con algo más?';
    session(['history' => $history]);


    $bot->reply($question);
});

$botman->hears('wearables', function($bot) {
    $history = session('history', []);
    $history[] = 'Usuario: ' . 'wearables';
    session(['history' => $history]);

    $question = Question::create('Claro, estos son nuestros productos de wearables: Producto A, Producto B, Producto C, ¿Necesitas ayuda con algo más?')
        ->fallback('Unable to ask question')
        ->callbackId('ask_more')
        ->addButtons([
            Button::create('Sí, por favor')->value('main_menu'),
            Button::create('No, gracias')->value('end_conversation'), 
        ]);

        
    $history = session('history', []);
    $history[] = 'Bot: ' . 'Claro, estos son nuestros productos de wearables: Producto A, Producto B, Producto C, ¿Necesitas ayuda con algo más?';
    session(['history' => $history]);


    $bot->reply($question);
});

$botman->hears('accesorios_electronicos', function($bot) {
    $history = session('history', []);
    $history[] = 'Usuario: ' . 'accesorios_electronicos';
    session(['history' => $history]);

    $question = Question::create('Claro, estos son nuestros productos de accesorios_electronicos: Producto A, Producto B, Producto C, ¿Necesitas ayuda con algo más?')
        ->fallback('Unable to ask question')
        ->callbackId('ask_more')
        ->addButtons([
            Button::create('Sí, por favor')->value('main_menu'),
            Button::create('No, gracias')->value('end_conversation'), 
        ]);

        
    $history = session('history', []);
    $history[] = 'Bot: ' . 'Claro, estos son nuestros productos de accesorios_electronicos: Producto A, Producto B, Producto C, ¿Necesitas ayuda con algo más?';
    session(['history' => $history]);


    $bot->reply($question);
});

$botman->hears('instrumentos_musicales', function($bot) {
    $history = session('history', []);
    $history[] = 'Usuario: ' . 'instrumentos_musicales';
    session(['history' => $history]);

    $question = Question::create('Claro, estos son nuestros productos de instrumentos_musicales: Producto A, Producto B, Producto C, ¿Necesitas ayuda con algo más?')
        ->fallback('Unable to ask question')
        ->callbackId('ask_more')
        ->addButtons([
            Button::create('Sí, por favor')->value('main_menu'),
            Button::create('No, gracias')->value('end_conversation'), 
        ]);

        
    $history = session('history', []);
    $history[] = 'Bot: ' . 'Claro, estos son nuestros productos de instrumentos_musicales: Producto A, Producto B, Producto C, ¿Necesitas ayuda con algo más?';
    session(['history' => $history]);


    $bot->reply($question);
});


/* ------------------ SEGUIMIENTO DE PEDIDO ---------------------------- */


$botman->hears('track_order', function($bot) {
    $bot->reply('Por favor, proporciona el número de tu pedido para rastrearlo.');
});

/* --------------------------------------------------------------------- */


$botman->hears('payload', function($bot) {

    $history = session('history', []);
    $history[] = 'Usuario: ' . '¿Cuales son los metodos de pago?';
    session(['history' => $history]);

    $question = Question::create("Los metodos de pago son: \n \n Paypal, \n \n Oxxo, \n \n Tarjeta de debito y credito, \n \n ¿Necesitas ayuda con algo mas?.")

        ->fallback('Unable to ask question')
        ->callbackId('ask_more')
        ->addButtons([
            Button::create('Sí, por favor')->value('main_menu'),
            Button::create('No, gracias')->value('end_conversation'), 
        ]);

        
    $history = session('history', []);
    $history[] = 'Bot: ' . 'El costo de envío a España es de 10 euros. ¿Necesitas ayuda con algo más?';
    session(['history' => $history]);


    $bot->reply($question);
});

$botman->hears('end_conversation', function(BotMan $bot) {
    // Cuando la conversación termina, guardar el historial en la base de datos
    $reply = '¡Gracias por usar el asistente virtual! Tu conversación ha sido guardada.';
    $history = session('history', []);
    $history[] = 'Bot: ' . $reply;
    session(['history' => $history]);

    // Identificación del usuario: correo electrónico si está autenticado, dirección IP si no lo está
    $userIdentification = auth()->check() ? auth()->user()->email : request()->ip();

    \App\Conversation::create([
        'user_identification' => $userIdentification,
        'conversation' => implode("\n", $history),
    ]);

    session()->forget('history');

    $bot->reply($reply);
});

$botman->fallback(function($bot) use ($mainMenu) {
    $history = session('history', []);
    $history[] = 'Usuario: ' . $bot->getMessage()->getText();
    session(['history' => $history]);

    $mainMenu($bot);
});

$botman->hears('add_{productId}', function($bot, $productId) {
    $product = DB::table('products')->where('id_products', $productId)->first();
    $bot->reply('<script>
        var cart = JSON.parse(localStorage.getItem("cart") || "[]");
        var product = ' . json_encode($product) . ';
        cart.push(product);
        localStorage.setItem("cart", JSON.stringify(cart));
    </script>');
});



$botman->hears('Start conversation', BotManController::class.'@startConversation');
