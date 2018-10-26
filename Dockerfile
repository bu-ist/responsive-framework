FROM wordpress

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar; \
	chmod +x wp-cli.phar; \
	mv wp-cli.phar /usr/local/bin/wp

COPY apache2-wrapper.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/apache2-wrapper.sh

COPY install-site.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/install-site.sh

ENTRYPOINT ["install-site.sh"]

CMD ["apache2-foreground"]
