# api-slim
Back end API development in Slim Micro framework

Uma simples api com um CRUD de carros desenvolvido com Slim Framework.

Após clonar o projeto rodar o seguinte comando:
$ composer update ou composer install para baixar as dependências do Slim.

Crie a seguinte tabela:

CREATE TABLE `cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `year` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1

Para rodar a aplicação utilizei o próprio servidor do PHP na porta 8000.
Com o comando via terminal:
$ php -S localhost:8000

Utilizei para teste de Rest uma excelente extensão do chrome.

Chama-se Postman.

Até o momento não fiz nenhuma integração com front-end mas isso é possível seja com JQuery, angular, Nodejs ou qualquer outra tecnologia de front.
