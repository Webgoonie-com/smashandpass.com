//  SPDX-License-Identifier: MIT

pragma solidity  ^0.8.0;


//import "@openzeppelin/contracts/utils/Counters.sol";
import "@openzeppelin/contracts/token/ERC721/extensions/ERC721URIStorage.sol";


contract SmashAndPassComERC721 is ERC721URIStorage {

    uint256 SMASH_TOKEN_ID;
    uint256 private _tokenIdCounter;

    constructor() ERC721("GoonieNFT","CN") {}

    function mintNFT(address _userOne, address _userTwo, string memory tokenURI) public {
        _mint(_userOne, SMASH_TOKEN_ID);
        _setTokenURI(SMASH_TOKEN_ID, tokenURI);
        SMASH_TOKEN_ID++;

        _mint(_userTwo, SMASH_TOKEN_ID);
        _setTokenURI(SMASH_TOKEN_ID, tokenURI);
        SMASH_TOKEN_ID++;

    }
}