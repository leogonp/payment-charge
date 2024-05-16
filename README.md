# Payment Charge

Essa aplicação possui um endpoint que gerencia importação e processamento de dados de pagamentos a partir de um csv.
Abaixo estão algumas dicas para instalação e configuração do projeto.

## Subindo a aplicação
Dentro da pasta `payment_charge`, execute o seguinte comando para executar todos os procedimentos para deixar a aplicação pronta para rodar localmente:

    make docker-install

A aplicação rodará na porta 8080.

## Rodando os testes

Para rodar os testes unitários e de feature, basta rodar o comando abaixo:

    make docker-test

## Importação
Abaixo está um exemplo de uso do endpoint.

`POST /api/import`

### Body
O body deve conter um campo chamado `file` e este deverá representar o csv que será enviado à api:

### cURL

    curl --location 'localhost:8080/api/import' \
    --form 'file=@"path/to/file.csv"'

### Response
Se tudo ocorrer com sucesso, a resposta terá com código http 201 e uma mensagem no seguinte formato:

    {
        "message": "Import was successfully made."
    }

## Aplicação

A aplicação frontend roda na pasta raiz da porta 8080.

## Portas:

- Aplicação roda na porta 8080
- phpmyadmin pode ser acessado através da porta 8081
- kafka-ui pode ser acessado através da porta 8082
