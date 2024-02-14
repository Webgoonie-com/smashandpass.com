const fs = require('fs');

// Read the SQL file
const sqlData = fs.readFileSync('path/to/your/sql/file.sql', 'utf-8');

// Extract data from SQL INSERT INTO statements
const insertRegex = /INSERT INTO `users` .*? VALUES (.*?);/g;
const matches = sqlData.match(insertRegex);

// Create an array of objects from the extracted data
const usersData = matches.map((match: { match: (arg0: RegExp) => string[]; }) => {
  const values = match.match(/\((.*?)\)/)[1].split(',').map(value => value.trim());
  return {
    id: values[0],
    uuid: '', // You need to decide how to generate or handle UUIDs
    name: values[5] ? values[5].replace(/'/g, '') : null,
    email: values[8].replace(/'/g, ''),
    // ... Map other fields similarly
    createdAt: values[30].replace(/'/g, ''),
    updatedAt: values[29].replace(/'/g, ''),
  };
});

// Create Prisma seeder file
const seederFileContent = `export const users = ${JSON.stringify(usersData, null, 2)};\n`;

// Write to the Prisma seeder file
fs.writeFileSync('path/to/your/seeder/file.ts', seederFileContent, 'utf-8');
