twig='/home/wpe-user/sites/uatpayeye/wp-content/themes/payeye2.0/cache/twig/'

echo ""
if [ -d $twig ]; then
  rm -r $twig
  echo "UAT success: clear twig cache"
else
  echo "UAT success: cache twig was not exist"
fi

wp wp-rest-cache flush
wp maintenance-mode deactivate
