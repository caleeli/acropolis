
context('Usuario Economía', () => {
    beforeEach(() => {
        cy.visit('http://localhost:9097');
        cy.viewport(375, 667);

        // Login
        cy.get('#login').click();
        cy.get('#email').type('economia-lapaz@nuevaacropolis.org');
        cy.get('#password').type('12345678');
        cy.get('#submit').click();
    })

    it('Registrar aporte mensual como admin', () => {
        cy.get('#ver-aportes-todos').click();
        cy.get('a i.fa-plus').click();
        cy.get('#miembro input').focus().type('econo');
        cy.get('span:contains("economia")').click();
        cy.get('#mes').select('10');
        cy.get('#gestion').clear().type('2019');
        cy.get('#fecha_pago').click();
        cy.get('.day:contains("17")').click();
        cy.get('#monto').clear().type('150');
        cy.get('#medio').select('Caja');
        cy.get('#recibo').clear().type('123');
        cy.get('input[type=file]').then(function (el) {
            cy.uploadFile('input[type=file]', 'example.json', 'application/json').then(() => {
                el[0].dispatchEvent(new Event('change', { bubbles: true }));
            });
        });
        cy.get('input[type=file]').then(function (el) {
            cy.uploadFile('input[type=file]', 'recibo.png', 'image/png').then(() => {
                el[0].dispatchEvent(new Event('change', { bubbles: true }));
            });
        });
        cy.get('#registrar').click();
        cy.wait('@postAporte');
        cy.wait('@getAportes/1');
        cy.get('.editar:first').click();
        cy.wait('@getAporte(1)');
    })
})
