function changerLangue() {
    const langue = document.getElementById("bouton-langue").value;
    window.location.href = `?lang=${langue}`;
}