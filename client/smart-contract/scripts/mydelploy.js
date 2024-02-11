const { ethers } = require("hardhat");

const main = async ()  =>{

    const smashPassFactory = await ethers.getContractFactory('SmashAndPassComERC721')
    const SmashAndPassContract = await smashPassFactory.deploy()

    console.log('SmashAndPass CONTRACT ADDRESS:', SmashAndPassContract.address)
}


main()
    .then(() => process.exit(0))
    .catch(error => {
        console.log('Error in deploying Contract >> ', error)
        process.exitCode = 1;
        process.exit(1)
    })