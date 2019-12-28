
context('Actions', () => {
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
        cy.get('.mensaje:first-child').click();
        cy.wait('@loadMessage');
        cy.get('a:contains("Ver mis aportes")').click();
    })
})
