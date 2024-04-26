export interface Product {
    SKU: string;
    name: string;
    price: number;
    sizeMB?: number;
    weightKg?: number;
    dimensions?: string;
}

export const dummyProductsData: Product[] = [
    // DVD-disc
    {
        SKU: 'DVD001',
        name: 'DVD-disc A',
        price: 10,
        sizeMB: 700,
    },
    {
        SKU: 'DVD002',
        name: 'DVD-disc B',
        price: 12,
        sizeMB: 650,
    },
    {
        SKU: 'DVD003',
        name: 'DVD-disc C',
        price: 15,
        sizeMB: 800,
    },
    {
        SKU: 'DVD004',
        name: 'DVD-disc D',
        price: 8,
        sizeMB: 600,
    },
    // Book
    {
        SKU: 'BOOK001',
        name: 'Book A',
        price: 20,
        weightKg: 1.2,
    },
    {
        SKU: 'BOOK002',
        name: 'Book B',
        price: 18,
        weightKg: 0.8,
    },
    {
        SKU: 'BOOK003',
        name: 'Book C',
        price: 25,
        weightKg: 1.5,
    },
    {
        SKU: 'BOOK004',
        name: 'Book D',
        price: 22,
        weightKg: 1.0,
    },
    // Furniture
    {
        SKU: 'FURN001',
        name: 'Furniture A',
        price: 150,
        dimensions: '120x80x40',
    },
    {
        SKU: 'FURN002',
        name: 'Furniture B',
        price: 200,
        dimensions: '150x100x50',
    },
    {
        SKU: 'FURN003',
        name: 'Furniture C',
        price: 180,
        dimensions: '100x60x30',
    },
    {
        SKU: 'FURN004',
        name: 'Furniture D',
        price: 170,
        dimensions: '80x50x20',
    },
];

