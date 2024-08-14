const ALERT_TYPES = Object.freeze({
  INFO: 'info',
  WARNING: 'warning',
  SUCCESS: 'success',
  ERROR: 'error',
});

const alertBox = {
  getAlertTitle(type) {
    return `${type.charAt(0).toUpperCase() + type.slice(1)}`;
  },

  showAlert(type = ALERT_TYPES.INFO, message = 'Alert', title = '') {
    alert(`${this.getAlertTitle(type)}: ${message}`);
  },
};
