# Introdução 
Este módulo é a base para os módulos OpenSource da comunidade The IT Nerd.

# Instalação
Instale via composer
```
composer require the_it_nerd/module-core
```

# Funcionalidades
Este módulo atua como base para os outros módulos provendo as seguintes fruncionalidades:
- Menu "The IT Nerd" no admin
- Aba de configuração "The IT Nerd" no admin
- Implementação de biblioteca de mascara no frontend
- Model para facilitar o uso de cache para armazenar objetos e variaveis 

## Como usar a biblioteca de mascara
A bilbioteca de mascaras utiliza como base a biblioteca [Igor Escobar jQuery Mask](github.com/igorescobar/jQuery-Mask-Plugin).

### Implementação por x-mage-init
Esta implementação leva em consideração o uso do incialização padrão do Magento 2 x-mage-init
```
<script type="text/x-magento-init">
{
    "#telephone": {
        "TheITNerd_Core/js/inputMask": {
            "mask": "(00) 0000-00000"
        }
    }
}
</script>

```

### Knockout data bind
Este modo pode ser usado em phtmls ou arquivos html de templates knockout utilizando o método data-bind
```
<input data-bind="mageInit:{ 'TheITNerd_Core/js/inputMask': {'mask': '(00) 0000-00000'}}"/>
```

### Implementação por requireJS
Quando for necessário o uso de implementação de mascara através de um arquivo JS.
```
define([
    'jquery',
    'TheITNerd_Core/js/inputMask'
], function($) {
    'use strict';

    $.widget('theitnerd.test', {
        options: {
            mask: '00000-000',
        },

        _create: function() {
            this.initMask();
        },

        /**
         * Implements Mask on field
         * @returns {theitnerd.test}
         */
        initMask: function() {
            this.element.inputmask({mask: this.options.mask});

            return this;
        }
    });

    return $.theitnerd.test;
});
```

## Como usar o model de cache
O model cache facilita o uso da implementação padrão de cache de backend do Magento2

### Como salvar uma cache
No cliente da cache temos o metodo save, que leva em consideração os seguintes parametros.

| Parâmetro                |              Descrição              | Observação                                                                                                                                                                             |
|--------------------------|:-----------------------------------:|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| string $key              |        Chave única da cache         | é esperado uma string para identificar a cache                                                                                                                                         |
| mixed $data              |         Dados serem salvos          | Pode ser passado qualquer variavel ou objeto que possa ser serializado.                                                                                                                |
| array $tags = []         |    Tags para facilitar a limpeza    | Por exemplo cms_p ou catalog_p                                                                                                                                                         |
| int $ttl = 86400         | Valor do tempo de validade da cache | O valor precisa ser do tipo int e o tempo é considerado em segundos, ou seja 86400 = 24h                                                                                               |
| string $scope = 'global' | O escopo usado para salvar a cache  | E$stá variavel espera os valores "store", "website" ou "global", e ele adicionara o ID do website ou da store atual na key da cache para diferenciar a cache por website ou store view |

### Como recuperar uma cache
O metodo Load facilita o carregametno o valores salvos em cache

| Parâmetro                |              Descrição              | Observação                                                                                                                                                                             |
|--------------------------|:-----------------------------------:|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| string $key              |        Chave única da cache         | é esperado uma string para identificar a cache                                                                                                                                         |
| string $scope = 'global' | O escopo usado para salvar a cache  | E$stá variavel espera os valores "store", "website" ou "global", e ele adicionara o ID do website ou da store atual na key da cache para diferenciar a cache por website ou store view |


### Exemplo de implementção 

```
use TheITNerd\Core\Model\CacheClient; 

class TestClass {

    /**
     * @param CacheClient   $cacheClient
     */
    public function __construct(
        private CacheClient   $cacheClient
    )
    {
    }    
    
    public function getData(string $key): array
    {
        //generate an unique cache key
        $cacheKey = md5($key);
        
        if($data = $this->cacheClient->load($cacheKey, 'website')) {
            return $data;
        }
        
        ...
        
        $data = array[]
        
        $this->cacheClient->save($cacheKey, $data, ['tag1, 'tag2'], 86400, 'website');
        
        return $data;
        
    }
    
    ...
}
```
