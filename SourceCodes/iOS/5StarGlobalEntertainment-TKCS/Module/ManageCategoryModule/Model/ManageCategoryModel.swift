//
//  ManageCategoryModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 06/02/23.
//

import Foundation
struct ManageCategoryModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: [ManagecategoryDetail]?
}

// MARK: - Datum
struct ManagecategoryDetail: Codable {
    var id, userID: Int?
    var name: String?
    var status: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?

    enum CodingKeys: String, CodingKey {
        case id
        case userID = "user_id"
        case name, status
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}
struct DeleteCategoryModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
}
