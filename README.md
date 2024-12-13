# **_Trabalho em Grupo da Disciplina de Ciência de dados 1_**
## Criação de um Banco de dados para uma Biblioteca 📚
## Requisitos do Código 🔗
📌 **RQ1**: Deve ser possível inserir, atualizar e deletar dados de todas as entidades. ✔ 


📌 **RQ2**: Deve ser possível listar os dados de todas as entidades. ✔ 


📌 **RQ3**: Deve ser possível somar, contar, calcular a média, máximo, mínimo de todas entidades. ✔
  
- _Média_ SELECT AVG(Preco) AS media_preco / FROM Produtos; 
- _Máximo_ SELECT MAX(Preco) AS produto_mais_caro / FROM Produtos; 
- _Mínimo_ SELECT MIN(Preco) AS produto_mais_barato / FROM Produtos; 


📌 **RQ4**: Implementar consultas SQL que utilizem junções para combinar dados de, pelo menos,  
duas tabelas relacionadas. ✔


📌 **RQ5**: Implementar consultas que combinem funções de agregação com a cláusula GROUP BY.  ✔
- _GROUP BY_ SELECT ID CLIENTE, SUM(Total) AS total_vendas,
  FROM Pedidos
  GROUP BY IDCliente;


📌 **RQ6**: Criar, pelo menos, duas visões (views) que consolidem informações úteis e 
frequentemente consultadas (utilize a criatividade dentro do seu problema).  ✔


📌 **RQ7**: Possuir interface gráfica (livre escolha ao grupo entre desktop, web ou mobile). ✔


📌 **RQ8**: Não utilizar ORM (Object Relational Mapping). ✔

## Requisitos do Relatório ✏
📌 O trabalho deve ser organizado, obrigatoriamente, nos mesmos grupos de quatro alunos do TG1. Cada
grupo deve entregar os seguintes itens compactados em um arquivo .zip ✔


📌 Relatório detalhado corrigido ✔ 


📌 Descrição do problema, contendo todas as suas restrições e especificidades. ✔ 


📌 Apresentação do DER e sua transformação no modelo lógico. ✔


📌 Regras de transformação utilizadas e justificativa das decisões de modelagem. ✔


📌Descrição das tecnologias adotadas (linguagens, SGBDs, versões, etc). 


📌Consultas formuladas para cada um dos requisitos. 


📌Telas capturadas da aplicação, demonstrando o funcionamento.

📌LINK: https://docs.google.com/document/d/1gk-s9IxYeieErr69tLQ0YhVtDtz9FW3na94vJGRWLoc/edit?usp=sharing
##
 #### 📍 Integrantes do grupo 
- Frederico de Souza Sicorra
- Gil Alves Magalhães
- Olavo Defendi Dalberto 
- Sarah de Farias
#### 📍 Professor Orientador
- Prof. Dr. Gabriel Machado Lunardi


