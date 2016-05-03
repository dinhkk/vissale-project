<?php
class CachingConfiguration {
	const ALLOW_CACHE = false; // có sử dụng cache hay không?
	const CACHING_NAMESPACE = 'fbsale_';
	const CONFIG_TTL = 2592000; // cache 1 thang
	const DEFAULT_STATUS_TTL = 2592000; // cache 1 thang
	const CONVERSATION_TTL = 1800; // cache 30p (chat trong 30 la cung)
	const COMMENT_CHAT_TTL = 1800; // cache 30p
}