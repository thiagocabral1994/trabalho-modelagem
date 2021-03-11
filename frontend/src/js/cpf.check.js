export default {
  validaCPF(cpf) {
    // Extrai os números da string
    cpf = cpf.replace(/\D/g, '');

    // cpf.match(...) verifica se a string não é uma sequencia de dígitos repetidos
    if (cpf.length != 11 || cpf.match(/(\d)\1{10}/) || cpf === "01234567890") {
      return false;
    }

    // Faz o cálculo para validar os dígitos verificadores
    for (let i = 9; i < 11; i++) {
      let j, c;
      for (j = 0, c = 0; c < i; c++) {
        j += cpf[c] * (i + 1 - c);
      }
      j = ((10 * j) % 11) % 10;
      if (cpf[c] != j) {
        return false;
      }
    }
    return true;
  },
};
