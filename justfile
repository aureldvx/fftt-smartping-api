@composer +script:
    composer --working-dir=clients/php run-script {{ script }}

@anon-xml *args:
	./anonymize.sh {{args}}

