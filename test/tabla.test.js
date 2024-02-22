const restar = require('../js/tabla.js');

describe('restar', () => {
    test('debería restar correctamente dos números', () => {
        const numRestado = 10;
        const numResta = 5;

        const resultado = restar(numRestado, numResta);
        expect(resultado).toBe(5);
    });
});
