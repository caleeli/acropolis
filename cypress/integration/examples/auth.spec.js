/// <reference types="Cypress" />

context('Usuario Miembro', () => {

    it('Registrar usuario', () => {
        cy.get('#register').click();
        cy.get('#name').type('test');
        cy.get('#email').type('test@nuevaacropolis.org');
        cy.get('#password').type('12345678');
        cy.get('#password-confirm').type('12345678');
    })
})
