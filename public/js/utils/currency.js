const currency = {
  convertToMoney(amount) {
    return new Intl.NumberFormat('en-IN', {
      style: 'decimal',
      currency: 'NPR',
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    }).format(amount);
  },
};
