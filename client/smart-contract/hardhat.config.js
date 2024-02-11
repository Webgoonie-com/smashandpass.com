/*
*   To run this file run the command with the following network --flag
*   npx hardhat run scripts/mydeploy.js --network sepolia
*   npx hardhat run scripts/deploy.js --network rinkeby
*/

//require("@nomicfoundation/hardhat-toolbox")
require("@nomiclabs/hardhat-waffle")
require('dotenv').config({ path: '.env' })

const ALCHEMY_API_URL = process.env.ALCHEMY_API_URL
const RINKEBY_PRIVATEKEY = process.env.RINKEBY_PRIVATEKEY
const SEPOLIA_PRIVATE_KEY = process.env.SEPOLIA_PRIVATE_KEY

/** @type import('hardhat/config').HardhatUserConfig */
module.exports = {
  solidity: "0.8.19",
  networks: {
    sepolia: {
      url: ALCHEMY_API_URL,
      accounts: [SEPOLIA_PRIVATE_KEY],
    },
    rinkeby: {
      url: ALCHEMY_API_URL,
      accounts: [RINKEBY_PRIVATEKEY],  //<< Pays for the gas fees
    },
  },
};
