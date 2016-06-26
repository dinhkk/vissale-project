cd .git/
chmod -R g+rwX .
chgrp -R nginx .
find . -type d -exec chmod g+s '{}' +
