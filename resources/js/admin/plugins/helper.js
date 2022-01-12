const helper = {
  convertToHtmlEntities (string) {
    return string.replace(/[\u00A0-\u9999<>\&]/gim, function (i) {
      return '&#' + i.charCodeAt(0) + ';'
    })
  }
}

export default helper
