<?php
// TODO HTTP_HOST는 사이트가 여러 환경에서 사용될 때 유용하다(로컬, 다른 로컬, 개발 서버 등) 보안에는 취약한 문제가 있으니 꼭 실제 도메인 이름을 사용할 것!!!
$domainName = "http://".$_SERVER['HTTP_HOST']."/"; 

/* $domains = array('domain.com', 'dev.domain.com', 'staging.domain.com', 'localhost');
if (in_array($_SERVER['HTTP_HOST'], $domains))
{
	$domain = $_SERVER['HTTP_HOST'];
}
else
{
	$domain = 'localhost';
} 이런 방법이나 */
/* switch ($_SERVER['HTTP_HOST']) {
	case 'domain.com':
		$domain = 'domain.com';
		break;
	case 'dev.domain.com':
		$domain = 'dev.domain.com';
		break;
	case 'staging.domain.com':
		$domain = 'staging.domain.com';
		break;
	default:
		$domain = 'local.domain';
		break;
} 이런 방법을 사용하면 괜찮을 듯*/

?>