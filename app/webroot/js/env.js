/**
 * Created by dinhkk on 11/25/16.
 */
var env = "local";
var chat_api = null;

switch (env) {

    case "test" :
        chat_api = "https://superapi.tk:1333";
        break;

    case "local" :
        chat_api = "http://vissale.dev:1337";
        break;
    default:
        chat_api = "https://vissale.com:1333";
        break;
}
