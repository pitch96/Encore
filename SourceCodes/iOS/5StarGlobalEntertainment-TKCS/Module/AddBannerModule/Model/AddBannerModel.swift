//
//  AddBannerModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 03/03/23.
//

import Foundation
// MARK: - Save Banner Model
struct SaveBannerModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: SaveBannerDetails?
}

// MARK: - SaveBannerDetails
struct SaveBannerDetails: Codable {
    var status, message: String?
}
