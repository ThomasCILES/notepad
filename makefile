ENCORE = "./node_modules/.bin/encore"

# Build production assets and install it
assets.install: encore.prod
	php bin/console assets:install --symlink

# Build development assets
encore.dev:
	$(ENCORE) dev

# Start development server with hot reload
encore.dev-server:
	$(ENCORE) dev-server

# Build production assets
encore.prod:
	$(ENCORE) production