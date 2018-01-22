// Expand a list of nodes containing dash intervals
// "1-3+5+9" -> 1,2,3,5,9
export const expand = function (factExp) {
  factExp = factExp.split('+')
  var exp, dashExpression
  exp = []
  for (var i = 0; i < factExp.length; i++) {
    dashExpression = factExp[i].split('-')
    if (dashExpression.length === 2) {
      for (var j = parseInt(dashExpression[0]); j < (parseInt(dashExpression[1]) + 1); j++) {
        exp.push(j)
      }
    } else exp.push(parseInt(factExp[i]))
  }
  exp.sort((a, b) => a - b) // sort numerically and ascending
  for (i = 1; i < exp.length; i++) {
    if (exp[i] === exp[i - 1]) {
      exp.splice(i--, 1)
    }
  }
  return exp
}