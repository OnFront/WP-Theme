#!/bin/bash

echo Hello, "$USER"!
echo "It's nice to meet you. I am here to help you process with migration."
echo "This is a super easy. Don't worry about it. I will care you!"
echo ""
echo "=== OUR RELEASE PLAN ==="
echo "1. Enable maintenance mode in UAT and PROD."
echo "2. Visit: http://uatpayeye.wpengine.com/ and http://payeye.com/. The maintenance mode should working correct."
echo "3. Login in https://wpengine.com/ and set copy environment UAT to PROD. Please select include 'File system'. Write correct email address and submit the process."
echo "4. WP Engine will continue the process and send you email message if process has ben success."
echo "5. If you got success email I will disable maintenance mode in UAT and PROD env."
echo "6. We are done!"
echo "=== THE END ==="
echo ""
read -r -p "Are you ready [y/N] ?: " ready

if [ "$ready" == "y"  ]; then
    echo ""
    echo "Great!"
    echo "I enable maintenance mode in UAT nad PROD env. Please wait!"

    ssh -tT uatpayeye@uatpayeye.ssh.wpengine.net <<< "$(cat uat/enable-maintenance.sh)"
    ssh -tT payeye@payeye.ssh.wpengine.net <<< "$(cat prod/enable-maintenance.sh)"

    echo ""
    read -r -p "Maintenance mode is enable. Please visit ${USER}: http://uatpayeye.wpengine.com/ and http://payeye.com/. Is correct [y/N] ?: " maintenanceEnable

    if [ "$maintenanceEnable" == "y" ]; then
      echo "Great! Now is your turn ${USER}."
      echo ""
      read -r -p "Please go to https://wpengine.com/ and copy environment UAT to PROD. Please select 'File system'. Write correct e-mail address and submit the process. Did you do it [y/N] ?: " wpEngine

      echo ""
      if [ "$wpEngine" == "y" ]; then
          echo "Good job! Now we are wait for email message! (about 90 seconds)"
          read -r -p "Have you received email with success message [y/N] ?: " successEmail

          if [ "$successEmail" == "y" ]; then
              echo ""
              echo "Great! Now is my turn. I disable maintenance mode in PROD na UAT. Please wait!"

              ssh -tT payeye@payeye.ssh.wpengine.net <<< "$(cat prod/disable-maintenance.sh)"
              ssh -tT uatpayeye@uatpayeye.ssh.wpengine.net <<< "$(cat uat/disable-maintenance.sh)"

              echo ""
              echo "Congratulations we are done! Thank you ${USER}. Bye!"
          else
              echo ""
              read -r -p "Have you received email with failed message [y/N] ?: " failedEmail

              if [ "$failedEmail" == "y" ]; then
                  echo ""
                  echo "WP Engine does a rollback automatically!"
                  echo "I disable maintenance mode in PROD and UAT. Please contact with WP Engine Support"

                  ssh -tT payeye@payeye.ssh.wpengine.net <<< "$(cat prod/disable-maintenance.sh)"
                  ssh -tT uatpayeye@uatpayeye.ssh.wpengine.net <<< "$(cat uat/disable-maintenance.sh)"
              else
                  echo ""
                  echo "It is impossible. Please wait for an e-mail or contact support. Bye"
              fi
          fi

      else
        echo "Don't worry you can start process again!"
      fi

    else
      echo "Don't worry you can start process again!"
    fi
else
    echo "You are not ready? It is no problem. Come back to me when you're ready :)"
fi
