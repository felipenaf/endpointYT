# endpointYT

![](https://img.shields.io/badge/php-7.3-blue) ![](https://img.shields.io/badge/composer-1.6.3-orange) ![](https://img.shields.io/badge/phpunit-6.5.5-green)

# Sobre
Uma api de endpoint único, com a objetivo de listar os dez vídeos mais populares baseados na palavra-chave passada.

# Iniciando
## Pré-requisitos
- `PHP`
- `composer`
- `PHPUnit`

## Instalação
- #### 1. Clonar o repositório
```
   $ git clone https://github.com/felipenaf/endpointYT
```
- #### 2. Instalação de pacote
```
    $ composer install
```
## Observações
- #### 1. API Key
    Será necessário informar uma chave para poder acessar a API.
    Na pasta `/config` tem um arquivo chamado `youtube.ini.sample`. Será necessário criar uma cópia desse arquivo com o nome `youtube.ini` e nele passar a chave que você encontra em [Youtube Credentials](https://console.developers.google.com/apis/credentials)

- #### 2. Endpoints e Parâmetros
    (*) Parâmetros obrigatórios
    | Endpoint | Param #1 | Param #2 |
    | :---: | :---: | :---: |
    | search | q (*) | channelId |
    ---
    | Parâmetro |Tipo| Pode Vazio | Tamanho mínimo |
    | :---: | :---: | :---: | :---: |
    | q |string| não | 3 |
    | channelId |string| não | não |

    Endpoints válidos:
    - `search?q=php`
    - `search?q=focus&channelId=UC1bjWVLp2aaJmPcNbi9OOsw`

    Endpoints inválidos:
    - `search?channelId=UC1bjWVLp2aaJmPcNbi9OOsw`
    - `search?q=ph`
- #### 3. Testes unitários
```
    $ ./vendor/bin/phpunit tests
```

> Importante lembrar que os comandos passados devem ser executados na raiz do projeto
