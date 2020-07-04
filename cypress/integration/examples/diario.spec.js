
context('Diario de ingresos y egresos', () => {
    beforeEach(() => {
        // Login
        cy.get('#login').click();
        cy.get('#email').type('economia-lapaz@nuevaacropolis.org');
        cy.get('#password').type('12345678');
        cy.get('#submit').click();
    })

    it('Ver saldo en caja', () => {
        cy.get('[data-cy=saldo-caja]').click();
        cy.get('[data-cy="tabla.row.edit"]:first').click();
    })
})
