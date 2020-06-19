
context('Usuario Miembro', () => {
    beforeEach(() => {
        // Login
        cy.get('#login').click();
        cy.get('#email').type('economia-lapaz@nuevaacropolis.org');
        cy.get('#password').type('12345678');
        cy.get('#submit').click();
    })

    it('Ver aportes mensuales', () => {
        cy.dbSeed('SpecAportesSeeder');
        cy.reload();
        cy.get('.mensaje:first-child').click();
        cy.wait('@loadMessage');
        cy.get('a:contains("Ver mis aportes")').click();
        cy.get('a:contains("Ver detalles")').click();
        cy.get('a.view-image:first').click();
        cy.get('img.recibo:visible');
        cy.get('a.view-image:first').click();
        cy.get('img.recibo:visible').should('not.exist');
    })
})
