twig='/home/wpe-user/sites/payeye/wp-content/themes/payeye2.0/cache/twig/'

echo ""
if [ -d $twig ]; then
  rm -r $twig
  echo "PROD success: clear twig cache"
else
  echo "PROD success: cache twig was not exist"
fi

wp wp-rest-cache flush
wp maintenance-mode deactivate
