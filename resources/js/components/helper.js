const XRegExp = require('xregexp');

let matchingDomainAndIconForServices = {
  'youtube.com': ['fab', 'youtube'],
  'github.com': ['fab', 'github']
};

window.appHelper = {

  /**
   * Получение аббревиатуры из строки - есть 2 режима - если слово одно то берёться все буквы слова но небольше
   * чем maxLetters, если слов несколько то беруться первые буквы этих слов но небольше чем maxLetters.
   * @param {String} str - входная строка
   * @param {Number} maxLetters - максимальное число в возвращаемой аббревиатуре
   * @param {Boolean} [parseFullAbbreviationWord=true] - учитываеться что если само слово являеться аббревиатурой то оно полностью пристыковываеться к результату
   * @param {Boolean} [detectCamelCase=true] - учитываеться верблюжий стиль (camelCase)
   * @param {Boolean} [detectSnakeCase=true] - учитываеться змеиный стиль (snake_case)
   * @param {Boolean} [detectKebabCase=true] - учитываеться шампурный стиль (kebab-case)
   * @returns {string}
   */
  getAbbreviation(str, maxLetters = 3, parseFullAbbreviationWord = true, detectCamelCase = true, detectSnakeCase = true, detectKebabCase = true) {
    let words = (detectCamelCase ? str.replace(XRegExp('([\\p{Ll}0-9])(\\p{Lu})', 'gm'), '$1 $2').replace(XRegExp('(\\p{Lu})(\\p{Lu})([\\p{Ll}0-9])', 'gm'), '$1 $2$3') : str)
      .split(RegExp('[\\s' + (detectSnakeCase?"_":"") + (detectKebabCase?"\\-":"") + ']+', 'gim'));
    let isFewWords = words.length > 1;

    let result = '';

    if(isFewWords) {
      for(let word of words) {

        if(parseFullAbbreviationWord && word === word.toUpperCase())
          result += word;
        else
          result += word.substr(0, 1);
      }
    } else {
      result = words[0];
    }

    return result.substr(0, maxLetters);
  },

  /**
   * Домен из URL
   * @param url
   * @returns {boolean|string}
   */
  domainFromUrl(url) {
    var result = false;
    var match
    if (match = url.match(/^(?:https?:\/\/)?(?:[^@\n]+@)?(?:www\.)?([^:\/\n\?\=]+)/im)) {
      result = match[1]
      if (match = result.match(/^[^\.]+\.(.+\..+)$/)) {
        result = match[1]
      }
    }
    return result
  },

  /**
   * Получить Font Awesome иконку сервиса по url - работает для плагина @fortawesome/vue-fontawesome
   * @param url
   * @returns {string|array}
   */
  getFaIconServiceFromUrl(url) {
    let domain = appHelper.domainFromUrl(url);
    if(!!domain && domain in matchingDomainAndIconForServices)
      return matchingDomainAndIconForServices[domain];
    return 'globe';
  },

  /**
   * Плоскую коллекцию в дерево
   * @param {Array} arr - исходная коллекция
   * @param {String} children - имя свойства в котором находяться вложенные элементы
   * @param {String} parentId - имя свойства в котором находиться id родителя
   * @param {String} elId - имя свойства в котором находиться id элемента
   * @returns {[]}
   */
  flatToTree(arr, children = 'children', parentId = 'parent_id', elId = 'id') {
    var r = []
    arr.forEach(function (a) {
      if(this[a[elId]]) {
        a[children] = this[a[elId]][children];
        this[a[elId]] = a;
      } else {
        this[a[elId]] = a;
      }

      if (a[parentId] === null) {
        r.push(this[a[elId]])
      } else {
        this[a[parentId]] = this[a[parentId]] || {}
        this[a[parentId]][children] = this[a[parentId]][children] || []
        this[a[parentId]][children].push(this[a[elId]])
      }
    }, Object.create(null))
    return r;
  },
};