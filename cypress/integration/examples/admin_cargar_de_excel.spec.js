
context('Usuario Economía', () => {
    beforeEach(() => {
        // Login
        cy.get('#login').click();
        cy.get('#email').type('economia-lapaz@nuevaacropolis.org');
        cy.get('#password').type('12345678');
        cy.get('#submit').click();
    });

    it('Cargar registros desde Excel', () => {
        cy.get('#ver-aportes-todos').click();
        cy.get('[data-cy=import-excel]').click();
        cy.get('input[type=file]').then(function (el) {
            cy.uploadFile('input[type=file]', 'aportes.xls', 'application/vnd.ms-excel').then(() => {
                el[0].dispatchEvent(new Event('change', { bubbles: true }));
            });
        });
    });
})
