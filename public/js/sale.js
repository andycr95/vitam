const formatterPeso = new Intl.NumberFormat('es-CO', {
    style: 'currency',
    currency: 'COP',
    minimumFractionDigits: 0
})

for (let i = 0; i < document.getElementsByClassName('precio').length; i++) {
    const e = document.getElementsByClassName('precio')[i];
    e.innerHTML = formatterPeso.format(e.innerHTML)
}
