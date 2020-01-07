/// <reference types="Cypress" />

context('Usuario Miembro', () => {
    beforeEach(() => {
        cy.viewport(375, 667);
        cy.visit('http://localhost:9097');
    })

    it('Registrar usuario', () => {
        cy.get('#register').click();
        cy.get('#name').type('test');
        cy.get('#email').type('test@nuevaacropolis.org');
        cy.get('#password').type('12345678');
        cy.get('#password-confirm').type('12345678');
    })
})
