Для запуска проекта введите эти команды в терминале:
1. git clone https://github.com/ochinchind/dummyposts.git
2. cd dummyposts
3. composer install
4. php artisan sail:install (Выбрать pgsql)
5. alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
6. source ~/.zshrc  # or source ~/.bashrc
7. sail up
8. После этого внутри терминала докера нужно будет ввести php artisan migrate
