//
//  ManageBannerModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 02/03/23.
//

import Foundation
// MARK: - Manage Banner Model
struct ManageBannerModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: [BannerDetails]?
}

// MARK: - BannerDetails
struct BannerDetails: Codable {
    var id: Int?
    var description: String?
    var bannerImage: String?
    var status: Int?
    var deletedAt: String?
    var createdAt: String?
    var updatedAt: String?

    enum CodingKeys: String, CodingKey {
        case id, description
        case bannerImage = "banner_image"
        case status
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}
// MARK: - Delete Banner Model
struct DeleteBannerModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
   // var data: String?
}
// MARK: - Banner Status Model
struct BannerStatusModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: String?
}
