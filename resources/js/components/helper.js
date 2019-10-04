const XRegExp = require('xregexp');

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
  getAbbreviation(
    str,
    maxLetters = 3,
    parseFullAbbreviationWord = true,
    detectCamelCase = true,
    detectSnakeCase = true,
    detectKebabCase = true
  ) {
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
  }
};