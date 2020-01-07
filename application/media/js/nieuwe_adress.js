$(document).ready(function () {
    $('#privatetoogler').on('click', function () {
        $('#nieuweadressprivate').toggleClass('active');
        $('#nieuweadressbedrijf').toggleClass('active');
    });
    $('#bedrijftoogler').on('click', function () {
        $('#nieuweadressprivate').toggleClass('active');
        $('#nieuweadressbedrijf').toggleClass('active');
    });
});