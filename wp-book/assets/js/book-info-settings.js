function wpbkDisplayRecalculate( oldVal ) {
    
   let newVal = document.getElementById('wpbk-base-currency').value;
   if ( newVal != oldVal ) {
       let recalc_label = document.getElementById('price-recalculate-label');
       document.getElementById('wpbk-require-price-recalculate').style.display = "inline-block";
       recalc_label.style.display = "inline";
       recalc_label.innerHTML = recalc_label.innerHTML.substring(0, recalc_label.innerHTML.indexOf('-') ) + ' -> ' + newVal;
       document.getElementById('price-recalculate-description1').style.display = "block";
   } else {
    document.getElementById('wpbk-require-price-recalculate').style.display = "none";
    document.getElementById('price-recalculate-label').style.display = "none";
    document.getElementById('price-recalculate-description1').style.display = "none";
    document.getElementById('price-recalculate-warning').style.display = "none";
    document.getElementById('forex-rate-type').style.display = "none";
    document.getElementById('wpbk-recalc-button').style.display = "none";
    document.getElementById('wpbk-require-price-recalculate').checked = false;
   }
}

function wpbkSubmitLink() {
    let recalcValue = document.getElementById('wpbk-require-price-recalculate').checked;
    if ( recalcValue ) {
        document.getElementById('wpbk-recalc-button').style.display = "table";
        document.getElementById('forex-rate-type').style.display = "block";
        document.getElementById('wpbk-recalc-button').style.marginTop = "10px";
        document.getElementById('price-recalculate-warning').style.display = "table";
    } else {
        document.getElementById('wpbk-recalc-button').style.display = "none";
        document.getElementById('price-recalculate-warning').style.display = "none";
        document.getElementById('forex-rate-type').style.display = "none";
    }
}