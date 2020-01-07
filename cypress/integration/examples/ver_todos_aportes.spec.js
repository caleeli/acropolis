
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

    it('Ver aportes mensuales', () => {
        cy.dbSeed('SpecAportesSeeder');
        cy.reload();
        cy.get('#ver-aportes-todos').click();
        cy.get('#miembro input').focus().type('econo');
        cy.get('span:contains("economia")').click();
        cy.wait('@getAportes/1');
        cy.get('a.view-image:first').click();
        cy.get('button.verificar:first').click();
        cy.wait('@updateAporte');
        cy.get('a.view-image:first').click();
        cy.get('button:contains("Ver más")').click();
        cy.wait('@getAportes/1');
        cy.get('#miembro .fa-times').click();
        cy.wait('@getAportesInicial');
    })
})
