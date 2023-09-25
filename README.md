# Plugin WordPress: XML Personalizado para plataformas de busca de medicamentos

Este é um plugin WordPress personalizado desenvolvido para gerar um arquivo XML contendo informações de produtos do WooCommerce. O objetivo é criar um feed de produtos que pode ser usado para anunciar medicamentos em plataformas como Cliquefarma, Consulta Remédios, Preço Medicamentos, Farma Index ou em qualquer outro lugar onde um feed XML seja necessário.

## Funcionalidades

- Gera automaticamente um arquivo XML com informações de produtos do WooCommerce.
- Agendamento de tarefas para atualizar o arquivo XML a cada hora (configurável).

## Instalação

1. Faça o download do plugin como um arquivo ZIP.
2. Faça o upload do arquivo ZIP do plugin para o WordPress.
3. Ative o plugin.

## Configuração

Após a instalação e ativação do plugin, você pode acessar a geração do arquivo XML de duas maneiras:

### 1. Através de uma URL

- Para gerar o arquivo XML manualmente, acesse a seguinte URL no seu navegador:

https://seusite.com/wordpress/?direct=true

Substitua `seusite.com/wordpress` pelo URL real do seu site.

#### 1.1. Criação de uma página privada

- Recomenda-se que seja criada uma página privada para evitar indexação e que pessoas sem as devidas permissões acessem.
- Nesta página privada você pode criar um botão personalizado com link de redirecionamento para a chamada da função.

### 2. Agendamento Automático

- O plugin está configurado para gerar automaticamente o arquivo XML a cada hora. Isso é ajustável nas configurações do plugin.

## Agendamento Automático

O plugin usa a função de agendamento interna do WordPress para executar a geração do XML automaticamente. O intervalo padrão é de uma hora, mas você pode alterá-lo conforme necessário.

## Logs de Erro

O plugin foi configurado para registrar erros e exceções em um arquivo de log. Você pode verificar esses logs para depurar problemas. Os logs estão localizados na pasta `logs` dentro da pasta do plugin.

## Personalização

Este é um plugin personalizado desenvolvido para um caso de uso específico. Você pode personalizar o código-fonte conforme necessário para atender às suas necessidades específicas.

## Licença

Este plugin é distribuído sob a [licença MIT](LICENSE).

## Suporte

Este é um projeto de código aberto e não possui suporte oficial. No entanto, você pode abrir problemas (issues) neste repositório no GitHub se encontrar problemas ou tiver perguntas.

## Autor

- [Melksedeque Silva](https://github.com/Melksedeque)

---

**Aviso**: Este plugin foi desenvolvido para fins educacionais e de demonstração. Certifique-se de revisar e personalizar o código de acordo com as necessidades do seu site antes de usar em um ambiente de produção.
