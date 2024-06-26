<?php

return [
    'name' => 'Auth',
    'uri_get_token_facebook'=> 'https://graph.facebook.com/v3.1/me?fields=id,name,email,link,birthday,gender&access_token=',
    'uri_get_token_google'=> 'https://www.googleapis.com/oauth2/v3/tokeninfo?id_token='
];
