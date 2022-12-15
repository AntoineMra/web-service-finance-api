# Finance API Web Service Antoine Marionneau

Le projet consiste à réaliser une api qui recommande à l’utilisateur les entreprises côté en bourse à proximité. D’une part l’obtention des entreprise de proximité sera obtenu à travers l’API Google Maps et d’autre part l’API Yahoo Finance se charge de fournir les informations du titre boursiers lié à l’entreprise.

![Untitled](https://s3-us-west-2.amazonaws.com/secure.notion-static.com/16430476-8d24-4042-9d86-6bdc3f957960/Untitled.png)

<aside>
📌 Violet → API Custom | Bleu → API Google Maps | Vert → API Yahoo Finance
</aside>

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --pull --no-cache` to build fresh images
3. Run `docker compose up` (the logs will be displayed in the current shell)
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.

## Docs

1. [Build options](docs/build.md)
