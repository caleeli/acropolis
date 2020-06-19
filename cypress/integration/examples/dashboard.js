
context('Dashboard', () => {
    beforeEach(() => {
        // Login
        cy.get('#login').click();
        cy.get('#email').type('economia-lapaz@nuevaacropolis.org');
        cy.get('#password').type('12345678');
        cy.get('#submit').click();
    })

    it('Revisa dashboard', () => {
    })
})
